<?php

namespace App\Http\Controllers;

use App\Models\MentorshipRequest;
use App\Models\Mentorship;
use App\Http\Requests\StoreMentorshipRequest;
use Illuminate\Support\Facades\Auth;

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
        MentorshipRequest::create([
            'mentee_id' => Auth::id(),
            'mentor_id' => $request->alumni_id,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Mentorship request sent.');
    }

    public function accept(MentorshipRequest $mentorshipRequest)
    {
        $this->authorize('respond', $mentorshipRequest);

        $mentorshipRequest->update(['status' => 'accepted']);

        Mentorship::create([
            'mentor_id' => $mentorshipRequest->alumni_id,
            'mentee_id' => $mentorshipRequest->student_id,
            'status' => 'active',
            'start_date' => now(),
        ]);

        return back()->with('success', 'Mentorship request accepted.');
    }

    public function reject(MentorshipRequest $mentorshipRequest)
    {
        $this->authorize('respond', $mentorshipRequest);
        $mentorshipRequest->update(['status' => 'rejected']);

        return back()->with('success', 'Mentorship request rejected.');
    }
}
