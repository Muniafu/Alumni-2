<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mentorship;
use App\Models\User;

class MentorshipSeeder extends Seeder
{
    public function run(): void
    {
        $alumni = User::where('email', 'alumni@alumni.edu')->first();
        $student = User::where('email', 'student@alumni.edu')->first();

        Mentorship::firstOrCreate([
            'mentor_id' => $alumni->id,
            'mentee_id' => $student->id,
            'status' => 'active',
            'goal' => 'Career guidance in tech industry',
            'start_date' => now(),
            'end_date' => now()->addMonth(3),
        ]);
    }
}
