<?php

namespace App\Http\Controllers;

use App\Models\MentorshipRequest;
use App\Models\Mentorship;
use App\Http\Requests\StoreMentorshipRequest;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MentorshipRequestNotification;
use App\Notifications\MentorshipAcceptedNotification;

class MentorshipRequestController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('alumni')) {
            $requests = MentorshipRequest::where('mentor_id', Auth::id())->where('status', 'pending')->get();
        } else {
            $requests = MentorshipRequest::where('mentee_id', Auth::id())->get();
        }

        return view('mentorship.requests.index', compact('requests'));
    }

    public function store(StoreMentorshipRequest $request)
    {
        $mentorshipRequest = MentorshipRequest::create([
            'mentee_id' => Auth::id(),
            'mentor_id' => $request->alumni_id,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        // Notify mentor
        $mentorshipRequest->mentor->notify(new MentorshipRequestNotification($mentorshipRequest));

        return back()->with('success', 'Mentorship request sent.');
    }

    public function accept(MentorshipRequest $mentorshipRequest)
    {
        $this->authorize('respond', $mentorshipRequest);

        $mentorshipRequest->update(['status' => 'accepted']);

        $mentorship = Mentorship::create([
            'mentor_id' => $mentorshipRequest->mentor_id,
            'mentee_id' => $mentorshipRequest->mentee_id,
            'status' => 'active',
            'start_date' => now(),
        ]);

        // Notify mentee
        $mentorshipRequest->mentee->notify(new MentorshipAcceptedNotification($mentorship));

        return back()->with('success', 'Mentorship request accepted.');
    }

    public function reject(MentorshipRequest $mentorshipRequest)
    {
        $this->authorize('respond', $mentorshipRequest);
        $mentorshipRequest->update(['status' => 'rejected']);

        return back()->with('success', 'Mentorship request rejected.');
    }
}
