<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\ForumThread;
use App\Models\ForumPost;
use Illuminate\Support\Facades\Auth;

class ForumPostController extends Controller
{
    public function store(ForumThread $thread)
    {
        request()->validate([
            'body' => 'required|string',
        ]);

        ForumPost::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => request('body'),
        ]);

        return back()->with('success', 'Reply posted successfully');
    }
}
