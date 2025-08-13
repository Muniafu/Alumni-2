<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\JobPosting;
use App\Models\Mentorship;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_alumni' => User::role('alumni')->count(),
            'total_students' => User::role('student')->count(),
            'upcoming_events' => Event::where('start_date', '>=', now())->count(),
            'active_jobs' => JobPosting::count(),
            'active_mentorships' => Mentorship::where('status', 'active')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
