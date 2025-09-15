<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ProfileCompletedNotification;

class Profile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'current_job',
        'company',
        'bio',
        'social_links',
        'skills',
        'interests',
        'profile_completion',
    ];

    protected $casts = [
        'social_links' => 'array',
        'skills' => 'array',
        'interests' => 'array',
    ];

    protected $attributes = [
        'social_links' => [],
        'skills' => [],
        'interests' => [],
        'profile_completion' => 0,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calculateCompletion(): int
    {
        $totalFields = 10;
        $completedFields = 0;

        // User fields
        $userFields = ['name', 'email'];
        foreach ($userFields as $field) {
            if (!empty($this->user->$field)) {
                $completedFields++;
            }
        }

        // Profile fields
        $profileFields = [
            'phone', 'address', 'current_job',
            'company', 'bio'
        ];

        foreach ($profileFields as $field) {
            if (!empty($this->$field)) {
                $completedFields++;
            }
        }

        // Array fields
        $arrayFields = [
            'skills' => 1, // Need at least 1 skill
            'interests' => 1, // Need at least 1 interest
            'social_links' => 1 // Need at least 1 social link
        ];

        foreach ($arrayFields as $field => $minCount) {
            if (!empty($this->$field) && count($this->$field) >= $minCount) {
                $completedFields++;
            }
        }

        // Calculate percentage
        $completionPercentage = min(100, round(($completedFields / $totalFields) * 100));

        $this->profile_completion = $completionPercentage;
        $this->save();

        if ($completionPercentage === 100) {
            $this->user->notify(new ProfileCompletedNotification());
        }

        return $completionPercentage;
    }

    public function getSocialLink($platform)
    {
        return $this->social_links[$platform] ?? null;
    }
}
