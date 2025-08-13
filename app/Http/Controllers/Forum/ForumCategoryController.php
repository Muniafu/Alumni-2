<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\ForumCategory;

class ForumCategoryController extends Controller
{
    public function index()
    {
        $categories = ForumCategory::withCount('threads')->get();
        return view('forum.categories.index', compact('categories'));
    }

    public function show(ForumCategory $category)
    {
        $threads = $category->threads()->latest()->paginate(10);
        return view('forum.categories.show', compact('category', 'threads'));
    }
}
