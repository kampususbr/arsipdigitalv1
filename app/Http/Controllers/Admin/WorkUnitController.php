<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkUnit;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WorkUnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:workunit.view');
    }

    public function index()
    {
        $units = WorkUnit::orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(15);

        return view('admin.work-units.index', compact('units'));
    }

    public function create()
    {
        $this->authorize('create', WorkUnit::class);
        return view('admin.work-units.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', WorkUnit::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:work_units',
            'description' => 'nullable|string',
            'head_name' => 'nullable|string|max:255',
            'head_email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
        ]);

        $unit = WorkUnit::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'head_name' => $validated['head_name'],
            'head_email' => $validated['head_email'],
            'phone' => $validated['phone'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'status' => $validated['status'],
            'created_by' => auth()->id(),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'workunit.created',
            'model' => 'WorkUnit',
            'model_id' => $unit->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.work-units.index')
            ->with('success', 'Unit Kerja berhasil ditambahkan.');
    }

    public function edit(WorkUnit $unit)
    {
        $this->authorize('update', $unit);
        return view('admin.work-units.edit', compact('unit'));
    }

    public function update(Request $request, WorkUnit $unit)
    {
        $this->authorize('update', $unit);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:work_units,name,' . $unit->id,
            'description' => 'nullable|string',
            'head_name' => 'nullable|string|max:255',
            'head_email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
        ]);

        $unit->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'head_name' => $validated['head_name'],
            'head_email' => $validated['head_email'],
            'phone' => $validated['phone'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'status' => $validated['status'],
            'updated_by' => auth()->id(),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'workunit.updated',
            'model' => 'WorkUnit',
            'model_id' => $unit->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.work-units.index')
            ->with('success', 'Unit Kerja berhasil diperbarui.');
    }

    public function destroy(WorkUnit $unit)
    {
        $this->authorize('delete', $unit);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'workunit.deleted',
            'model' => 'WorkUnit',
            'model_id' => $unit->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $unit->delete();

        return redirect()->route('admin.work-units.index')
            ->with('success', 'Unit Kerja berhasil dihapus.');
    }
}
