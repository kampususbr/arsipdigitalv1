<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        
        $query = Document::with(['category', 'creator', 'workUnit']);

        // Filter berdasarkan role
        if (!$user->isAdmin()) {
            // Manager hanya lihat dokumen mereka dan kategori tertentu
            if ($user->isManager()) {
                // Manager bisa lihat semua dokumen yang tidak private
                $query->where(function ($q) use ($user) {
                    $q->where('visibility', '!=', 'private')
                        ->orWhere('created_by', $user->id);
                });
            } else if ($user->isUser()) {
                // User bisa lihat dokumen milik mereka dan public
                $query->where(function ($q) use ($user) {
                    $q->where('visibility', 'public')
                        ->orWhere('created_by', $user->id)
                        ->orWhereHas('accessRecords', function ($subQ) use ($user) {
                            $subQ->where('user_id', $user->id);
                        });
                });
            } else if ($user->isViewer()) {
                // Viewer hanya public dan yang diberi akses
                $query->where(function ($q) use ($user) {
                    $q->where('visibility', 'public')
                        ->orWhereHas('accessRecords', function ($subQ) use ($user) {
                            $subQ->where('user_id', $user->id);
                        });
                });
            }
        }

        // Filter berdasarkan kategori
        if (request('category')) {
            $query->where('category_id', request('category'));
        }

        // Search
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('document_number', 'like', "%{$search}%");
            });
        }

        $documents = $query->active()->orderBy('created_at', 'desc')->paginate(15);
        $categories = DocumentCategory::active()->sorted()->get();

        return view('documents.index', compact('documents', 'categories'));
    }

    public function create()
    {
        if (!auth()->user()->can('document.create')) {
            abort(403);
        }

        $categories = DocumentCategory::active()->sorted()->get();
        $workUnits = \App\Models\WorkUnit::active()->sorted()->get();

        return view('documents.create', compact('categories', 'workUnits'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('document.create')) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:document_categories,id',
            'work_unit_id' => 'nullable|exists:work_units,id',
            'document_number' => 'nullable|string|max:100',
            'document_date' => 'nullable|date',
            'file' => 'required|file|mimes:pdf|max:5120',
            'visibility' => 'required|in:public,restricted,private',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            
            // Generate unique filename
            $uniqueName = time() . '_' . Str::random(10) . '.pdf';
            $filePath = $file->storeAs('documents', $uniqueName, 'local');

            $document = Document::create([
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']) . '-' . time(),
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'work_unit_id' => $validated['work_unit_id'],
                'file_name' => $fileName,
                'file_path' => $filePath,
                'file_type' => $file->getMimeType(),
                'file_size' => $fileSize,
                'document_number' => $validated['document_number'],
                'document_date' => $validated['document_date'],
                'created_by' => auth()->id(),
                'visibility' => $validated['visibility'],
            ]);

            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'document.created',
                'model' => 'Document',
                'model_id' => $document->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->route('documents.show', $document)
                ->with('success', 'Dokumen berhasil diupload.');
        }

        return back()->with('error', 'Terjadi kesalahan saat mengupload file.');
    }

    public function show(Document $document)
    {
        if (!$document->isAccessibleBy(auth()->user())) {
            abort(403);
        }

        // Increment view count
        $document->increment('view_count');

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'document.viewed',
            'model' => 'Document',
            'model_id' => $document->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('documents.show', compact('document'));
    }

    public function download(Document $document)
    {
        if (!$document->isAccessibleBy(auth()->user())) {
            abort(403);
        }

        // Increment download count
        $document->increment('download_count');

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'document.downloaded',
            'model' => 'Document',
            'model_id' => $document->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return Storage::download($document->file_path, $document->file_name);
    }

    public function edit(Document $document)
    {
        if (!auth()->user()->can('document.edit') || 
            (!auth()->user()->isAdmin() && $document->created_by !== auth()->id())) {
            abort(403);
        }

        $categories = DocumentCategory::active()->sorted()->get();
        $workUnits = \App\Models\WorkUnit::active()->sorted()->get();

        return view('documents.edit', compact('document', 'categories', 'workUnits'));
    }

    public function update(Request $request, Document $document)
    {
        if (!auth()->user()->can('document.edit') || 
            (!auth()->user()->isAdmin() && $document->created_by !== auth()->id())) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:document_categories,id',
            'work_unit_id' => 'nullable|exists:work_units,id',
            'document_number' => 'nullable|string|max:100',
            'document_date' => 'nullable|date',
            'visibility' => 'required|in:public,restricted,private',
        ]);

        $document->update($validated + ['updated_by' => auth()->id()]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'document.updated',
            'model' => 'Document',
            'model_id' => $document->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('documents.show', $document)
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document)
    {
        if (!auth()->user()->can('document.delete')) {
            abort(403);
        }

        // Delete file from storage
        Storage::delete($document->file_path);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'document.deleted',
            'model' => 'Document',
            'model_id' => $document->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}
