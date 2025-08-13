<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventManagementController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return back()->with('success', 'Event deleted successfully');
    }
}
