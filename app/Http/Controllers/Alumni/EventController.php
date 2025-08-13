<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alumni\StoreEventRequest;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('created_by', Auth::id())->paginate(10);
        return view('alumni.events.index', compact('events'));
    }

    public function create()
    {
        return view('alumni.events.create');
    }

    public function store(StoreEventRequest $request)
    {
        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('alumni.events.index')->with('success', 'Event created successfully');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $event->delete();
        return back()->with('success', 'Event deleted successfully');
    }
}
