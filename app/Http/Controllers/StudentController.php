<?php

namespace App\Http\Controllers;

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
        $profile = $user->profile;

        return view('student.dashboard', compact('user', 'profile'));
    }

    public function editProfile()
    {
        Gate::authorize('edit-profile', Auth::user());

        $user = Auth::user();
        $profile = $user->profile ?? new Profile();

        return view('student.profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        Gate::authorize('edit-profile', Auth::user());

        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
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
            'bio' => $request->bio,
            'social_links' => $socialLinks,
        ];

        if ($user->profile) {
            $user->profile->update($profileData);
        } else {
            $user->profile()->create($profileData);
        }

        return redirect()->route('student.dashboard')
            ->with('success', 'Profile updated successfully');
    }

}
