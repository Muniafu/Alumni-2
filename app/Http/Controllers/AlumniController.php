<?php

namespace App\Http\Controllers;

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
        $profile = $user->profile;

        return view('alumni.dashboard', compact('user', 'profile'));
    }

    public function editProfile()
    {
        Gate::authorize('edit-profile', Auth::user());

        $user = Auth::user();
        $profile = $user->profile ?? new Profile();

        return view('alumni.profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        Gate::authorize('edit-profile', Auth::user());

        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'current_job' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'linkedin' => ['nullable', 'url'],
            'twitter' => ['nullable', 'url'],
        ]);

        $user->update([
            'name' => $request->name,
        ]);

        $socialLinks = [
            'linkedin' => $request->linkedin,
            'twitter' => $request->twitter,
        ];

        $profileData = [
            'phone' => $request->phone,
            'address' => $request->address,
            'current_job' => $request->current_job,
            'company' => $request->company,
            'bio' => $request->bio,
            'social_links' => $socialLinks,
        ];

        if ($user->profile) {
            $user->profile->update($profileData);
        } else {
            $user->profile()->create($profileData);
        }

        return redirect()->route('alumni.dashboard')
            ->with('success', 'Profile updated successfully');
    }

}
