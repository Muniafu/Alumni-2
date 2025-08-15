<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $conversations = Conversation::with(['latestMessage', 'otherUsers'])
            ->forUser(auth()->id())
            ->latest('updated_at')
            ->paginate(10);

        return view('messaging.index', compact('conversations'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $users = User::where('id', '!=', auth()->id())
            ->approved()
            ->get();

        return view('messaging.create', compact('users'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'recipients' => 'required|array|min:1',
            'recipients.*' => 'exists:users,id',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:1',
        ]);

        $conversation = Conversation::create([
            'subject' => $request->subject,
        ]);

        // Attach participants
        $participants = array_unique(array_merge($request->recipients, [auth()->id()]));
        $conversation->users()->attach($participants);

        // Add first message
        $conversation->messages()->create([
            'user_id' => auth()->id(),
            'body' => $request->message,
        ]);

        return redirect()->route('conversations.show', $conversation)
            ->with('success', 'Conversation started successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Conversation $conversation)
    {

        $this->authorize('view', $conversation);

        $conversation->markAsReadForUser(auth()->id());

        $messages = $conversation->messages()
            ->with('sender')
            ->latest()
            ->paginate(15);

        return view('messaging.show', compact('conversation', 'messages'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Conversation $conversation)
    {

        $this->authorize('delete', $conversation);

        $conversation->delete();

        return redirect()->route('conversations.index')
            ->with('success', 'Conversation deleted successfully');

    }

}
