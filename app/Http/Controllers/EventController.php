<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\EventRsvp;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $events = Event::with('organizer')
            ->upcoming()
            ->orderBy('start')
            ->paginate(10);

        return view('events.index', compact('events'));

    }

    /**
     * Show the form for viewing the calender for an event.
     */
    public function calendar()
    {
        return view('events.calendar');
    }

    public function getCalenderEvents(Request $request)
    {

        $start = $request->start;
        $end = $request->end;

        $events = Event::whereBetween('start', [$start, $end])
            ->orWhereBetween('end', [$start, $end])
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start->toIso8601String(),
                    'end' => $event->end->toIso8601String(),
                    'location' => $event->location,
                    'url' => route('events.show', $event->id),
                    'color' => $event->is_online ? '#3b82f6' : '#10b981',
                ];
            });

        return response()->json($events);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Event::class);

        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        Gate::authorize('create', Event::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'capacity' => 'nullable|integer|min:1',
            'is_online' => 'boolean',
            'meeting_url' => 'nullable|url|required_if:is_online,true',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $validated['user_id'] = auth()->id();

        $event = Event::create($validated);

        return redirect()->route('events.show', $event)
            ->with('success', 'Event created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {

        $userRsvp = $event->rsvps()->where('user_id', auth()->id())->first();
        $attendees = $event->rsvps()->with('user')->where('status', 'going')->get();

        return view('events.show', compact('event', 'userRsvp', 'attendees'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        Gate::authorize('update', $event);

        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {

        Gate::authorize('update', $event);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'capacity' => 'nullable|integer|min:1',
            'is_online' => 'boolean',
            'meeting_url' => 'nullable|url|required_if:is_online,true',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('events.show', $event)
            ->with('success', 'Event updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {

        Gate::authorize('delete', $event);

        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully');

    }

    /**
     * RSVP to an event.
     */
    public function rsvp(Request $request, Event $event)
    {
        $validated = $request->validate([
            'status' => 'required|in:going,interested,not_going',
            'guests' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        $rsvp = $event->rsvps()->updateOrCreate(
            ['user_id' => auth()->id()],
            $validated
        );

        return back()->with('success', 'RSVP status updated');
    }

    /**
     * Cancel RSVP for an event.
     */
    public function cancelRsvp(Event $event)
    {
        $event->rsvps()->where('user_id', auth()->id())->delete();

        return back()->with('success', 'RSVP cancelled');
    }
    
}
