<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ProfileDetailsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the logged-in user's profile (read-only view).
     */
    public function show(Request $request): View
    {
        $user = $request->user();
        $profile = $user->profile;

        return view('profile.show', compact('user', 'profile'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $profile = $user->profile ?? $user->profile()->create([
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

        $profile->calculateCompletion();

        return view('profile.edit', compact('user', 'profile'));
    }

    /**
     * Update the user's basic profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's extended profile details.
     */
    public function updateDetails(ProfileDetailsRequest $request): RedirectResponse
    {
        $user = $request->user();
        $profileData = $request->validated();

        // Process skills and interests
        $profileData['skills'] = isset($profileData['skills'])
            ? array_filter(array_map('trim', explode(',', $profileData['skills'])))
            : [];

        $profileData['interests'] = isset($profileData['interests'])
            ? array_filter(array_map('trim', explode(',', $profileData['interests'])))
            : [];

        // Process social links
        $socialLinks = [
            'linkedin' => $profileData['linkedin'] ?? null,
            'twitter' => $profileData['twitter'] ?? null,
            'github' => $profileData['github'] ?? null,
            'website' => $profileData['website'] ?? null,
        ];
        $profileData['social_links'] = array_filter($socialLinks);

        // Remove temporary fields
        unset(
            $profileData['linkedin'],
            $profileData['twitter'],
            $profileData['github'],
            $profileData['website']
        );

        // Update or create profile
        $user->profile()->updateOrCreate([], $profileData);
        $user->profile->calculateCompletion();

        return Redirect::route('profile.edit')->with('status', 'profile-details-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
