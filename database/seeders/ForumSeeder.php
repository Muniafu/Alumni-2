<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ForumCategory;
use App\Models\ForumThread;
use App\Models\ForumPost;
use App\Models\User;
use Illuminate\Support\Str;

class ForumSeeder extends Seeder
{
    public function run()
    {
        $alumni = User::where('email', 'alumni@alumni.edu')->first();
        $student = User::where('email', 'student@alumni.edu')->first();

        // Career Advice category
        $careerCategory = ForumCategory::firstOrCreate(
            ['slug' => 'career-advice'],
            [
                'name' => 'Career Advice',
                'description' => 'Discussions on jobs, interviews, and career growth.'
            ]
        );

        // General Discussion category
        $generalCategory = ForumCategory::firstOrCreate(
            ['slug' => 'general-discussion'],
            [
                'name' => 'General Discussion',
                'description' => 'Talk about anything alumni-related.',
            ]
        );

        // Create thread in Career Advice
        $thread = ForumThread::firstOrCreate(
            ['slug' => 'tips-for-landing-your-first-tech-job'],
            [
                'title' => 'Tips for Landing Your First Tech Job',
                'forum_category_id' => $careerCategory->id,
                'user_id' => $alumni->id,
                'content' => 'Initial post content'
            ]
        );

        // Original post
        ForumPost::firstOrCreate(
            [
                'forum_thread_id' => $thread->id,
                'user_id' => $alumni->id,
                'content' => 'Networking, portfolio projects, and continuous learning are key!'
            ]
        );

        // Reply from student
        ForumPost::firstOrCreate(
            [
                'forum_thread_id' => $thread->id,
                'user_id' => $student->id,
                'content' => 'Thanks for sharing! Any tips for remote interviews?'
            ]
        );
    }
}
