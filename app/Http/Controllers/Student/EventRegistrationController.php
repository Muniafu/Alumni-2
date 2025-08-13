<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventRegistrationController extends Controller
{
    public function register(Event $event)
    {
        Auth::user()->events()->attach($event->id);
        return back()->with('success', 'Registered for event successfully');
    }

    public function unregister(Event $event)
    {
        Auth::user()->events()->detach($event->id);
        return back()->with('success', 'Unregistered from event');
    }
}
