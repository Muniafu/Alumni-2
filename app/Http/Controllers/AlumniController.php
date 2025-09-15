<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class AlumniController extends Controller
{
    public function dashboard()
    {
        Gate::authorize('access-alumni-dashboard');
        $user = Auth::user();
        $this->ensureProfileExists($user);

        $profile =$user->profile;
        $userJobPostings = JobPosting::where('user_id', $user->id)
            ->withCount('applications')
            ->latest()
            ->take(5)
            ->get();

        $upcomingAlumniEvents = Event::upcoming()
            ->with(['rsvps' => function($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->latest()
            ->take(3)
            ->get()
            ->each(function ($event) use ($user) {
                $event->is_registered = $event->rsvps->contains('user_id', $user->id);
            });

        $canPostJobs = $user->can('create jobs');
        $canViewEvents = $user->can('view events');

        return view('alumni.dashboard', compact(
            'user',
            'profile',
            'canPostJobs',
            'canViewEvents',
            'userJobPostings',
            'upcomingAlumniEvents',
        ));
    }

    public function editProfile()
    {
        Gate::authorize('edit-profile', Auth::user());
        $user = Auth::user();
        $this->ensureProfileExists($user);

        return view('alumni.profile', [
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
            'current_job' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'linkedin' => ['nullable', 'url'],
            'twitter' => ['nullable', 'url'],
            'github' => ['nullable', 'url'],
            'website' => ['nullable', 'url'],
            'skills' => ['nullable', 'string'],
            'interests' => ['nullable', 'string'],
        ]);

        $user->update(['name' => $validated['name']]);

        $profileData = $this->prepareProfileData($validated);
        $user->profile()->updateOrCreate([], $profileData);
        $user->profile->calculateCompletion();

        return redirect()->route('alumni.dashboard')
            ->with('success', 'Profile updated successfully');
    }

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
        ];
    }
}
