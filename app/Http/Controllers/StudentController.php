<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

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
}
