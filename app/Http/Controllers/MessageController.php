<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Notifications\NewMessageNotification;
use Illuminate\Support\Facades\Notification;

class MessageController extends Controller
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
    public function store(Request $request, Conversation $conversation)
    {

        $this->authorize('view', $conversation);

        $request->validate([
            'body' => 'required|string|min:1',
        ]);

        $message = $conversation->messages()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        // Update conversation updated_at to bump it in the list
        $conversation->touch();

        // Notify other participants
        $recipients = $conversation->users()->where('users.id', '!=', auth()->id())->get();
        Notification::send($recipients, new NewMessageNotification($message));

        return redirect()->route('conversations.show', $conversation)
            ->with('success', 'Message sent successfully');

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
    public function destroy(Message $message)
    {

        $this->authorize('delete', $message);

        $conversation = $message->conversation;
        $message->delete();

        return redirect()->route('conversations.show', $conversation)
            ->with('success', 'Message deleted successfully');

    }
    
}
