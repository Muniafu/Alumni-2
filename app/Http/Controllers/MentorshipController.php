<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mentorship;
use App\Models\MentorshipRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MentorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $mentorships = Mentorship::with(['mentor', 'mentee'])
            ->where(function($query) {
                $query->where('mentor_id', Auth::id())
                    ->orWhere('mentee_id', Auth::id());
            })
            ->latest()
            ->paginate(10);

        return view('mentorship.index', compact('mentorships'));

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Mentorship $mentorship)
    {

        $this->authorize('view', $mentorship);

        $mentorship->load(['mentor.profile', 'mentee.profile']);
        return view('mentorship.show', compact('mentorship'));

    }


    public function showMentor(User $mentor)
    {

        $mentor->load('profile');
        $existingRequest = MentorshipRequest::where('mentor_id', $mentor->id)
            ->where('mentee_id', Auth::id())
            ->first();

        return view('mentorship.show-mentor', compact('mentor', 'existingRequest'));

    }


    public function findMentors()
    {

        $mentors = User::role('alumni')
            ->with('profile')
            ->whereHas('profile', function($query) {
                $query->whereNotNull('current_job')
                    ->orWhereNotNull('skills');
            })
            ->paginate(15);

        return view('mentorship.find-mentors', compact('mentors'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }



    public function sendRequest(Request $request, User $mentor)
    {

        $request->validate([
            'message' => 'required|string|min:10|max:1000',
            'goal' => 'required|string|min:10|max:500',
        ]);

        $existingRequest = MentorshipRequest::where('mentor_id', $mentor->id)
            ->where('mentee_id', Auth::id())
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'You have already sent a request to this mentor.');
        }

        MentorshipRequest::create([
            'mentor_id' => $mentor->id,
            'mentee_id' => Auth::id(),
            'message' => $request->message,
            'goal' => $request->goal,
        ]);

        return redirect()->route('mentorship.requests.sent')
            ->with('success', 'Mentorship request sent successfully');

    }


    public function myRequests()
    {

        $receivedRequests = MentorshipRequest::with(['mentee', 'mentor'])
            ->where('mentor_id', Auth::id())
            ->latest()
            ->paginate(10, ['*'], 'received_page');

        $sentRequests = MentorshipRequest::with(['mentee', 'mentor'])
            ->where('mentee_id', Auth::id())
            ->latest()
            ->paginate(10, ['*'], 'sent_page');

        return view('mentorship.requests', compact('receivedRequests', 'sentRequests'));

    }



    public function respondToRequest(Request $request, MentorshipRequest $mentorshipRequest)
    {

        $this->authorize('respond', $mentorshipRequest);

        $request->validate([
            'response' => 'required|in:accept,reject',
            'message' => 'nullable|string|max:500',
        ]);

        if ($request->response === 'accept') {
            $mentorshipRequest->update(['status' => 'accepted']);

            Mentorship::create([
                'mentor_id' => $mentorshipRequest->mentor_id,
                'mentee_id' => $mentorshipRequest->mentee_id,
                'goal' => $mentorshipRequest->goal,
                'start_date' => now(),
            ]);

            return back()->with('success', 'Mentorship request accepted. A new mentorship has been established.');
        } else {
            $mentorshipRequest->update([
                'status' => 'rejected',
                'message' => $request->message ?? 'Request declined',
            ]);

            return back()->with('success', 'Mentorship request declined.');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mentorship $mentorship)
    {

        $this->authorize('update', $mentorship);

        $request->validate([
            'status' => 'required|in:active,completed,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        $mentorship->update([
            'status' => $request->status,
            'end_date' => in_array($request->status, ['completed', 'cancelled']) ? now() : null,
        ]);

        return back()->with('success', 'Mentorship updated successfully');

    }

}
