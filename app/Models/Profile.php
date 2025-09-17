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

    /**
     * Relationship to the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate profile completion percentage
     */
    public function calculateCompletion(): int
    {
        $completedFields = 0;

        // Fields to check
        $userFields = ['name', 'email'];
        $profileFields = ['phone', 'address', 'current_job', 'company', 'bio'];
        $arrayFields = ['skills', 'interests', 'social_links'];

        // Count completed user fields
        foreach ($userFields as $field) {
            if (!empty($this->user->$field)) {
                $completedFields++;
            }
        }

        // Count completed profile fields
        foreach ($profileFields as $field) {
            if (!empty($this->$field)) {
                $completedFields++;
            }
        }

        // Count array fields (at least 1 item)
        foreach ($arrayFields as $field) {
            if (!empty($this->$field) && count($this->$field) >= 1) {
                $completedFields++;
            }
        }

        // Dynamic total fields
        $totalFields = count($userFields) + count($profileFields) + count($arrayFields);

        // Calculate percentage
        $completionPercentage = min(100, round(($completedFields / $totalFields) * 100));

        // Update model
        $this->profile_completion = $completionPercentage;
        $this->save();

        // Send notification if fully completed (once)
        if ($completionPercentage === 100 && !$this->user->notifications()
            ->where('type', ProfileCompletedNotification::class)
            ->exists()) {
            $this->user->notify(new ProfileCompletedNotification());
        }

        return $completionPercentage;
    }

    /**
     * Get a specific social link
     */
    public function getSocialLink(string $platform): ?string
    {
        return $this->social_links[$platform] ?? null;
    }

    /**
     * Accessor: comma-separated skills
     */
    public function getSkillsListAttribute(): string
    {
        return implode(', ', $this->skills);
    }

    /**
     * Accessor: comma-separated interests
     */
    public function getInterestsListAttribute(): string
    {
        return implode(', ', $this->interests);
    }
}
