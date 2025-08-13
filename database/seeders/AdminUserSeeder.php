<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@alumni.edu',
            'password' => Hash::make('password'),
            'is_approved' => true,
        ]);

        $admin->assignRole('admin');

        // Create sample alumni
        $alumni = User::create([
            'name' => 'Alumni User',
            'email' => 'alumni@alumni.edu',
            'password' => Hash::make('password'),
            'student_id' => 'AL12345',
            'graduation_year' => '2020',
            'program' => 'Computer Science',
            'is_approved' => true,
        ]);

        $alumni->assignRole('alumni');

        // Create sample student
        $student = User::create([
            'name' => 'Student User',
            'email' => 'student@alumni.edu',
            'password' => Hash::make('password'),
            'student_id' => 'ST67890',
            'graduation_year' => '2025',
            'program' => 'Business Administration',
            'is_approved' => true,
        ]);

        $student->assignRole('student');
    }
}
