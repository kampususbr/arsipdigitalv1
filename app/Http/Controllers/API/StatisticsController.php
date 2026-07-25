<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use App\Models\DocumentCategory;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function overview()
    {
        return response()->json([
            'total_documents' => Document::active()->count(),
            'total_users' => User::active()->count(),
            'total_categories' => DocumentCategory::active()->count(),
            'documents_today' => Document::whereDate('created_at', today())->count(),
            'documents_this_month' => Document::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count(),
            'storage_used_bytes' => Document::active()->sum('file_size'),
        ]);
    }

    public function documentsByCategory()
    {
        return response()->json(
            DocumentCategory::active()
                ->withCount('documents')
                ->orderBy('documents_count', 'desc')
                ->get()
        );
    }

    public function documentsTrend()
    {
        $trend = Document::active()
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($trend);
    }
}
