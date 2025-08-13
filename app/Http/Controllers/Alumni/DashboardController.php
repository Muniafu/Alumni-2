<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\JobPosting;
use App\Models\Mentorship;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'my_events' => Event::where('created_by', $user->id)->count(),
            'my_jobs' => JobPosting::where('posted_by', $user->id)->count(),
            'my_mentorships' => Mentorship::where('mentor_id', $user->id)->count(),
        ];

        return view('alumni.dashboard', compact('stats'));
    }
}
