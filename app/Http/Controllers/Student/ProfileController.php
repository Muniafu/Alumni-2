<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Student\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;
        return view('student.profile.edit', compact('user', 'profile'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $user->update($request->only('name'));

        $profileData = [
            'phone' => $request->phone,
            'address' => $request->address,
            'bio' => $request->bio,
            'skills' => $request->skills ? array_map('trim', explode(',', $request->skills)) : [],
            'interests' => $request->interests ? array_map('trim', explode(',', $request->interests)) : [],
        ];

        $user->profile->update($profileData);
        $user->profile->calculateCompletion();

        return redirect()->route('student.dashboard')->with('success', 'Profile updated successfully');
    }
}
