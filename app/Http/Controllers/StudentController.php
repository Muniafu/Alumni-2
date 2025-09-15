<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Notifications\EventRsvpNotification;
use App\Notifications\JobApplicationNotification;

class StudentController extends Controller
{
    public function dashboard()
    {
        Gate::authorize('access-student-dashboard');
        $user = Auth::user();
        $this->ensureProfileExists($user);

        $user->load('profile');

        $canViewEvents = $user->can('view events');
        $canRSVPEvents = $user->can('rsvp events');
        $upcomingEvents = [];
        $recentJobs = [];

        if ($user->can('view events')) {
            $upcomingEvents = Event::upcoming()
                ->orderBy('start')
                ->limit(5)
                ->get();
        }

        $recentJobs = JobPosting::active()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('student.dashboard', [
            'user' => $user,
            'profile' => $user->profile,
            'canViewEvents' => $canViewEvents,
            'canRSVPEvents' => $canRSVPEvents,
            'upcomingEvents' => $upcomingEvents,
            'recentJobs' => $recentJobs
        ]);
    }

    public function editProfile()
    {
        Gate::authorize('edit-profile', Auth::user());
        $user = Auth::user();
        $this->ensureProfileExists($user);

        return view('student.profile', [
            'user' => $user,
            'profile' => $user->profile
        ]);
    }

    public function updateProfile(Request $request)
    {
        Gate::authorize('edit-profile', Auth::user());
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'linkedin' => ['nullable', 'url'],
            'twitter' => ['nullable', 'url'],
        ]);

        $user->update(['name' => $validated['name']]);

        $profileData = $this->prepareProfileData($validated);
        $user->profile()->updateOrCreate([], $profileData);
        $user->profile->calculateCompletion();

        return redirect()->route('student.dashboard')
            ->with('success', 'Profile updated successfully');
    }

    protected function ensureProfileExists(User $user): void
    {
        if (!$user->profile) {
            $user->profile()->create([
                'phone' => null,
                'address' => null,
                'bio' => null,
                'social_links' => [],
                'profile_completion' => 0,
            ]);
        }
    }

    protected function prepareProfileData(array $data): array
    {
        return [
            'phone' => $data['phone'],
            'address' => $data['address'],
            'bio' => $data['bio'],
            'social_links' => [
                'linkedin' => $data['linkedin'],
                'twitter' => $data['twitter'],
            ],
        ];
    }

    // RSVP to event
    public function rsvpEvent(Request $request, Event $event)
    {
        Gate::authorize('rsvp events');

        $user = Auth::user();

        if ($event->isFull() && $request->status === 'going') {
            return back()->with('error', 'This event is already full.');
        }

        $rsvp = $event->rsvps()->create([
            'user_id' => $user->id,
            'status' => $request->input('status', 'going'), // going | interested
            'guests' => $request->input('guests', 0),
            'notes' => $request->input('notes'),
        ]);

        // 🔔 Notify event organizer
        $event->organizer->notify(new EventRsvpNotification($rsvp));

        return back()->with('success', 'RSVP submitted successfully!');
    }


    // Apply to job posting
    public function applyJob(Request $request, JobPosting $job)
    {
        Gate::authorize('apply-job');

        $user = Auth::user();

        if (!$job->canApply($user)) {
            return back()->with('error', 'You cannot apply for this job.');
        }

        $application = $job->applications()->create([
            'user_id' => $user->id,
            'cover_letter' => $request->input('cover_letter'),
            'resume' => $request->input('resume'),
            'status' => 'pending',
        ]);

        // 🔔 Notify job poster
        $job->poster->notify(new JobApplicationNotification($application));

        return back()->with('success', 'Application submitted successfully!');
    }

}
