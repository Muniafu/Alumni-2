<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobPosting;
use App\Models\User;

class JobsSeeder extends Seeder
{
    public function run(): void
    {
        $alumni = User::where('email', 'alumni@alumni.edu')->first();

        $jobs = [
            [
                'title' => 'Software Engineer',
                'company' => 'TechCorp',
                'location' => 'Remote',
                'description' => 'We are looking for an experienced Laravel developer.',
                'type' => 'job',
                'is_remote' => true,
                'contact_email' => 'hr@techcorp.com',
                'user_id' => $alumni->id,
                'skills_required' => ['Laravel', 'PHP', 'MySQL'],
            ],
            [
                'title' => 'Business Analyst Intern',
                'company' => 'BizSolutions Ltd.',
                'location' => 'New York, NY',
                'description' => 'Internship opportunity for final-year business students.',
                'type' => 'internship',
                'is_remote' => false,
                'contact_email' => 'careers@bizsolutions.com',
                'user_id' => $alumni->id,
                'skills_required' => ['Excel', 'Data Analysis', 'Communication'],
            ],
        ];

        foreach ($jobs as $job) {
            JobPosting::firstOrCreate(
                ['title' => $job['title'], 'company' => $job['company']],
                $job
            );
        }
    }
}
