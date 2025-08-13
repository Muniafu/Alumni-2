<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Alumni\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;
        return view('alumni.profile.edit', compact('user', 'profile'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $user->update($request->only('name'));

        $socialLinks = [
            'linkedin' => $request->linkedin,
            'twitter' => $request->twitter,
            'github' => $request->github,
            'website' => $request->website,
        ];

        $profileData = [
            'phone' => $request->phone,
            'address' => $request->address,
            'current_job' => $request->current_job,
            'company' => $request->company,
            'bio' => $request->bio,
            'social_links' => $socialLinks,
            'skills' => $request->skills ? array_map('trim', explode(',', $request->skills)) : [],
            'interests' => $request->interests ? array_map('trim', explode(',', $request->interests)) : [],
        ];

        $user->profile->update($profileData);
        $user->profile->calculateCompletion();

        return redirect()->route('alumni.dashboard')->with('success', 'Profile updated successfully');
    }
}
