<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumPost;
use App\Models\ForumThread;
use App\Notifications\NewForumPostNotification;
use Illuminate\Support\Facades\Notification;

class ForumPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ForumThread $thread)
    {

        $request->validate([
            'content' => 'required|string|min:5',
        ]);

        $post = $thread->posts()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        // Notify thread subscribers (excluding the post author)
        $subscribers = $thread->subscribers()->where('user_id', '!=', auth()->id())->get();
        Notification::send($subscribers, new NewForumPostNotification($post));

        // Also notify thread author if they're not the one posting
        if ($thread->author_id != auth()->id() && !$thread->subscribers->contains($thread->author_id)) {
            $thread->author->notify(new NewForumPostNotification($post));
        }

        return redirect()->route('forum.threads.show', [
            'thread' => $thread,
            'page' => $thread->posts()->paginate(15)->lastPage(),
        ])->withFragment('post-' . $post->id);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ForumPost $post)
    {

        $this->authorize('update', $post);
        return view('forum.posts.edit', compact('post'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ForumPost $post)
    {

        $this->authorize('update', $post);

        $request->validate([
            'content' => 'required|string|min:5',
        ]);

        $post->update([
            'content' => $request->content,
        ]);

        return redirect()->route('forum.threads.show', [
            'thread' => $post->thread,
            'page' => $post->thread->posts()->paginate(15)->lastPage(),
        ])->withFragment('post-' . $post->id)
          ->with('success', 'Post updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ForumPost $post)
    {

        $this->authorize('delete', $post);

        $thread = $post->thread;
        $post->delete();

        // If this was the only post in the thread, delete the thread too
        if ($thread->posts()->count() === 0) {
            $thread->delete();
            return redirect()->route('forum.categories.show', $thread->category)
                ->with('success', 'Thread deleted successfully');
        }

        return redirect()->route('forum.threads.show', $thread)
            ->with('success', 'Post deleted successfully');

    }
}
