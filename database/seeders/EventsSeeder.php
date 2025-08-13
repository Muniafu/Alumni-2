<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

class EventsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@alumni.edu')->first();
        $alumni = User::where('email', 'alumni@alumni.edu')->first();

        $events = [
            [
                'title' => 'Annual Alumni Meetup',
                'description' => 'Join us for networking, fun, and career discussions with fellow alumni.',
                'location' => 'University Hall',
                'start' => Carbon::now()->addDays(15),
                'end' => Carbon::now()->addDays(15)->addHours(4),
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Web Development Workshop',
                'description' => 'Hands-on Laravel and ReactJS session by industry experts.',
                'location' => 'Tech Innovation Lab',
                'start' => Carbon::now()->addDays(30),
                'end' => Carbon::now()->addDays(30)->addHours(5),
                'user_id' => $alumni->id,
            ],
            [
                'title' => 'Past Business Networking Event',
                'description' => 'Recap and gallery from our successful networking event last year.',
                'location' => 'Business School Auditorium',
                'start' => Carbon::now()->subMonths(3),
                'end' => Carbon::now()->subMonths(3)->addHours(3),
                'user_id' => $admin->id,
            ],
        ];

        foreach ($events as $event) {
            Event::firstOrCreate(['title' => $event['title']], $event);
        }
    }
}
