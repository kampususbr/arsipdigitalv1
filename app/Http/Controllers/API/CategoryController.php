<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(
            DocumentCategory::active()->sorted()->get()
        );
    }

    public function show(DocumentCategory $category)
    {
        return response()->json($category->load('documents'));
    }
}
