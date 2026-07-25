<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with(['category', 'creator'])->active();

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%")
                ->orWhere('description', 'like', "%{$request->search}%");
        }

        return response()->json(
            $query->orderBy('created_at', 'desc')->paginate(15)
        );
    }

    public function show(Document $document)
    {
        if (!$document->isAccessibleBy(auth()->user())) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($document->load(['category', 'creator']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:document_categories,id',
            'file' => 'required|file|mimes:pdf|max:5120',
            'visibility' => 'required|in:public,restricted,private',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $uniqueName = time() . '_' . Str::random(10) . '.pdf';
            $filePath = $file->storeAs('documents', $uniqueName, 'local');

            $document = Document::create([
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']) . '-' . time(),
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'created_by' => auth()->id(),
                'visibility' => $validated['visibility'],
            ]);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'document.created',
                'model' => 'Document',
                'model_id' => $document->id,
                'ip_address' => $request->ip(),
            ]);

            return response()->json($document, 201);
        }

        return response()->json(['message' => 'File upload failed'], 400);
    }

    public function download(Document $document)
    {
        if (!$document->isAccessibleBy(auth()->user())) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $document->increment('download_count');

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'document.downloaded',
            'model' => 'Document',
            'model_id' => $document->id,
            'ip_address' => request()->ip(),
        ]);

        return Storage::download($document->file_path, $document->file_name);
    }
}
