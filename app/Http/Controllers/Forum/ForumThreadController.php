<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\ForumCategory;
use App\Models\ForumThread;
use Illuminate\Support\Facades\Auth;

class ForumThreadController extends Controller
{
    public function create(ForumCategory $category)
    {
        return view('forum.threads.create', compact('category'));
    }

    public function store(ForumCategory $category)
    {
        request()->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $thread = ForumThread::create([
            'category_id' => $category->id,
            'user_id' => Auth::id(),
            'title' => request('title'),
            'body' => request('body'),
        ]);

        return redirect()->route('forum.threads.show', $thread)->with('success', 'Thread created successfully');
    }

    public function show(ForumThread $thread)
    {
        $posts = $thread->posts()->latest()->paginate(10);
        return view('forum.threads.show', compact('thread', 'posts'));
    }
}
