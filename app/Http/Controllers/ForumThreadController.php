<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumCategory;
use App\Models\ForumThread;
use Illuminate\Support\Str;

class ForumThreadController extends Controller
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
    public function create(ForumCategory $category)
    {

        return view('forum.threads.create', compact('category'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ForumCategory $category)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
        ]);

        $thread = $category->threads()->create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
        ]);

        return redirect()->route('forum.threads.show', $thread)
            ->with('success', 'Thread created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(ForumThread $thread)
    {

        $thread->load(['author', 'category']);
        $posts = $thread->posts()
            ->with('author')
            ->paginate(15);

        return view('forum.threads.show', compact('thread', 'posts'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ForumThread $thread)
    {

        $this->authorize('update', $thread);
        return view('forum.threads.edit', compact('thread'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ForumThread $thread)
    {

        $this->authorize('update', $thread);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
        ]);

        $thread->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
        ]);

        return redirect()->route('forum.threads.show', $thread)
            ->with('success', 'Thread updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ForumThread $thread)
    {

        $this->authorize('delete', $thread);

        $category = $thread->category;
        $thread->delete();

        return redirect()->route('forum.categories.show', $category)
            ->with('success', 'Thread deleted successfully');

    }
    public function subscribe(ForumThread $thread)
    {
        $thread->subscribe();
        return back()->with('success', 'You have subscribed to this thread');
    }

    public function unsubscribe(ForumThread $thread)
    {
        $thread->unsubscribe();
        return back()->with('success', 'You have unsubscribed from this thread');
    }
}
