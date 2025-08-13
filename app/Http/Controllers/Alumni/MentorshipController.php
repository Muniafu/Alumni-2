<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Mentorship;
use Illuminate\Support\Facades\Auth;

class MentorshipController extends Controller
{
    public function index()
    {
        $mentorships = Mentorship::where('mentor_id', Auth::id())->paginate(10);
        return view('alumni.mentorships.index', compact('mentorships'));
    }
}
