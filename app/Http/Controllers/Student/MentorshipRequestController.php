<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\MentorshipRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Student\StoreMentorshipRequest;

class MentorshipRequestController extends Controller
{
    public function index()
    {
        $requests = MentorshipRequest::where('student_id', Auth::id())->paginate(10);
        return view('student.mentorship_requests.index', compact('requests'));
    }

    public function store(StoreMentorshipRequest $request)
    {
        MentorshipRequest::create([
            'student_id' => Auth::id(),
            'alumni_id' => $request->alumni_id,
            'message' => $request->message,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Mentorship request sent successfully');
    }
}
