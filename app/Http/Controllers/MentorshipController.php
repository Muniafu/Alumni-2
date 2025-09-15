<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mentorship;
use App\Models\MentorshipRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MentorshipRequestNotification;
use App\Notifications\MentorshipAcceptedNotification;
use App\Notifications\MentorshipStatusChangedNotification;
use Illuminate\Support\Facades\Notification;

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

        $existingMentorship = Mentorship::where('mentor_id', $mentor->id)
            ->where('mentee_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if ($existingMentorship) {
            return back()->with('error', 'You already have an active mentorship with this mentor.');
        }

        $mentorshipRequest = MentorshipRequest::create([
            'mentor_id' => $mentor->id,
            'mentee_id' => Auth::id(),
            'message' => $request->message,
            'goal' => $request->goal,
            'status' => 'pending',
        ]);

        // 🔔 Notify mentor
        $mentor->notify(new MentorshipRequestNotification($mentorshipRequest));

        // 🔔 Notify all admins
        $admins = User::role('admin')->get();
        Notification::send($admins, new MentorshipRequestNotification($mentorshipRequest));

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

            $mentorship = Mentorship::create([
                'mentor_id' => $mentorshipRequest->mentor_id,
                'mentee_id' => $mentorshipRequest->mentee_id,
                'goal' => $mentorshipRequest->goal,
                'start_date' => now(),
                'status' => 'active',
            ]);

            // 🔔 Notify mentee
            $mentorshipRequest->mentee->notify(new MentorshipAcceptedNotification($mentorship));

            // 🔔 Notify admins
            $admins = User::role('admin')->get();
            Notification::send($admins, new MentorshipAcceptedNotification($mentorship));

            return back()->with('success', 'Mentorship request accepted.');
        } else {
            $mentorshipRequest->update([
                'status' => 'rejected',
                'message' => $request->message ?? 'Request declined',
            ]);

            // 🔔 Notify mentee
            $mentorshipRequest->mentee->notify(
                new MentorshipStatusChangedNotification($mentorshipRequest, 'rejected')
            );

            // 🔔 Notify admins
            $admins = User::role('admin')->get();
            Notification::send($admins, new MentorshipStatusChangedNotification($mentorshipRequest, 'rejected'));

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

        $oldStatus = $mentorship->status;
        $newStatus = $request->status;

        $mentorship->update([
            'status' => $newStatus,
            'end_date' => in_array($newStatus, ['completed', 'cancelled']) ? now() : null,
            'notes' => $request->notes,
        ]);

        if ($oldStatus !== $newStatus) {
            // 🔔 Notify mentor + mentee
            $mentorship->mentor->notify(new MentorshipStatusChangedNotification($mentorship, $newStatus));
            $mentorship->mentee->notify(new MentorshipStatusChangedNotification($mentorship, $newStatus));

            // 🔔 Notify admins
            $admins = User::role('admin')->get();
            Notification::send($admins, new MentorshipStatusChangedNotification($mentorship, $newStatus));
        }

        return back()->with('success', 'Mentorship updated successfully');
    }
}
