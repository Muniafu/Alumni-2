<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\JobPosting;
use App\Models\MentorshipRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'registered_events' => $user->events()->count(),
            'applied_jobs' => $user->jobApplications()->count(),
            'mentorship_requests' => MentorshipRequest::where('student_id', $user->id)->count(),
        ];

        return view('student.dashboard', compact('stats'));
    }
}
