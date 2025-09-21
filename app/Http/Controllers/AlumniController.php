<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\JobPosting;
use App\Models\User;
use App\Models\Mentorship;
use App\Models\ForumCategory;
use App\Models\ForumThread;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AlumniController extends Controller
{
    /**
     * Display the alumni dashboard.
     */
    public function dashboard()
    {
        Gate::authorize('access-alumni-dashboard');

        $user = Auth::user();
        $this->ensureProfileExists($user);
        $profile = $user->profile;
        $profile->calculateCompletion();

        // Jobs: Recent + user's postings
        $recentJobs = JobPosting::active()->with('poster')->latest()->take(5)->get();
        $userJobPostings = JobPosting::where('user_id', $user->id)
            ->withCount('applications')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($job) => tap($job, fn($j) => $j->canViewApplications = $user->can('viewApplications', $job)));

        // Events: Upcoming + user's past events for create preview
        $upcomingAlumniEvents = Event::upcoming()
            ->with(['rsvps' => fn($q) => $q->where('user_id', $user->id)])
            ->latest()
            ->take(3)
            ->get()
            ->each(fn($event) => $event->is_registered = $event->rsvps->contains('user_id', $user->id));
        $userEvents = Event::where('user_id', $user->id)->latest()->take(3)->get(); // For create section

        // Mentorships: Offered/Requested
        $mentorshipsOffered = $user->mentorships()->latest()->take(3)->get();
        $mentorshipsRequested = $user->mentorshipRequests()->latest()->take(3)->get();

        // Forums: Categories + user's recent threads
        $forumCategories = ForumCategory::withCount(['threads', 'posts'])->take(3)->get();
        $userThreads = ForumThread::where('user_id', $user->id)->latest()->take(3)->get();

        // Permissions (hyphenated to match gates)
        $permissions = [
            'create-jobs' => $user->can('create-jobs'),
            'view-jobs' => true,
            'create-events' => $user->can('create-events'),
            'view-events' => $user->can('view-events'),
            'create-forums' => $user->can('create-forums'),
            'view-forums' => $user->can('view-forums'),
            'create-mentorship' => $user->can('create-mentorship'),
            'view-mentorship' => $user->can('view-mentorship'),
        ];

        return view('alumni.dashboard', compact(
            'user', 'profile',
            'recentJobs', 'userJobPostings',
            'upcomingAlumniEvents', 'userEvents',
            'mentorshipsOffered', 'mentorshipsRequested',
            'forumCategories', 'userThreads',
            'permissions'
        ));
    }

    /**
     * Show edit profile page.
     */
    public function editProfile()
    {
        /** @var User $user */
        $user = Auth::user();
        Gate::authorize('edit-profile', $user);
        $this->ensureProfileExists($user);

        return view('alumni.profile', [
            'user' => $user,
            'profile' => $user->profile
        ]);
    }

    /**
     * Update the alumni profile.
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        Gate::authorize('edit-profile', $user);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'current_job' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'linkedin' => ['nullable', 'url'],
            'twitter' => ['nullable', 'url'],
            'github' => ['nullable', 'url'],
            'website' => ['nullable', 'url'],
            'skills' => ['nullable', 'string'],
            'interests' => ['nullable', 'string'],
            'education' => ['nullable', 'string', 'max:255'],
            'certifications' => ['nullable', 'string'],
        ]);

        $user->update(['name' => $validated['name']]);

        $profileData = $this->prepareProfileData($validated);
        $user->profile()->updateOrCreate([], $profileData);

        $user->profile->calculateCompletion();

        return redirect()->route('alumni.dashboard')
            ->with('success', 'Profile updated successfully');
    }

    /**
     * Ensure that a user has a profile.
     */
    protected function ensureProfileExists(User $user): void
    {
        if (!$user->profile) {
            $user->profile()->create([
                'phone' => null,
                'address' => null,
                'current_job' => null,
                'company' => null,
                'bio' => null,
                'social_links' => [],
                'skills' => [],
                'interests' => [],
                'profile_completion' => 0,
            ]);
        }
    }

    /**
     * Prepare profile data from the validated request.
     */
    protected function prepareProfileData(array $data): array
    {
        return [
            'phone' => $data['phone'],
            'address' => $data['address'],
            'current_job' => $data['current_job'],
            'company' => $data['company'],
            'bio' => $data['bio'],
            'social_links' => [
                'linkedin' => $data['linkedin'],
                'twitter' => $data['twitter'],
                'github' => $data['github'],
                'website' => $data['website'],
            ],
            'skills' => isset($data['skills'])
                ? array_filter(array_map('trim', explode(',', $data['skills'])))
                : [],
            'interests' => isset($data['interests'])
                ? array_filter(array_map('trim', explode(',', $data['interests'])))
                : [],
            'education' => $data['education'],
            'certifications' => isset($data['certifications'])
                ? array_filter(array_map('trim', explode(',', $data['certifications'])))
                : [],
        ];
    }
}
