<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Total statistics
        $totalDocuments = Document::active()->count();
        $totalUsers = User::active()->count();
        $totalCategories = DocumentCategory::active()->count();
        $totalSize = Document::active()->sum('file_size');

        // Documents uploaded today
        $documentsToday = Document::whereDate('created_at', today())->count();
        
        // Documents uploaded this month
        $documentsThisMonth = Document::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Storage usage
        $storageUsed = $totalSize;
        $storageUsedGB = number_format($storageUsed / (1024 * 1024 * 1024), 2);
        $storageUsedPercent = min(($storageUsed / (10 * 1024 * 1024 * 1024)) * 100, 100);

        // Documents by category (for chart)
        $documentsByCategory = DocumentCategory::active()
            ->withCount('documents')
            ->orderBy('documents_count', 'desc')
            ->get();

        // Recent activity logs
        $recentActivities = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Documents uploaded in last 7 days (for chart)
        $documentsLast7Days = Document::active()
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top categories
        $topCategories = DocumentCategory::active()
            ->withCount('documents')
            ->orderBy('documents_count', 'desc')
            ->limit(5)
            ->get();

        // Documents per user
        $documentsPerUser = Document::active()
            ->select('created_by')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('created_by')
            ->with('creator')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(5)
            ->get();

        // Most viewed documents
        $mostViewedDocuments = Document::active()
            ->orderBy('view_count', 'desc')
            ->limit(5)
            ->get();

        // Most downloaded documents
        $mostDownloadedDocuments = Document::active()
            ->orderBy('download_count', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalDocuments',
            'totalUsers',
            'totalCategories',
            'documentsToday',
            'documentsThisMonth',
            'storageUsed',
            'storageUsedGB',
            'storageUsedPercent',
            'documentsByCategory',
            'recentActivities',
            'documentsLast7Days',
            'topCategories',
            'documentsPerUser',
            'mostViewedDocuments',
            'mostDownloadedDocuments',
            'user'
        ));
    }
}
