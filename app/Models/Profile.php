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

    protected $attributes = [
        'social_links' => '',
        'skills' => '',
        'interests' => '',
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
     * Accessors for array-like fields
     */
    public function getSkillsArrayAttribute(): array
    {
        return $this->skills ? explode(',', $this->skills) : [];
    }

    public function getInterestsArrayAttribute(): array
    {
        return $this->interests ? explode(',', $this->interests) : [];
    }

    public function getSocialLinksArrayAttribute(): array
    {
        return $this->social_links ? explode(',', $this->social_links) : [];
    }

    /**
     * Mutators to save array as comma-separated string
     */
    public function setSkillsAttribute($value)
    {
        $this->attributes['skills'] = is_array($value) ? implode(',', $value) : $value;
    }

    public function setInterestsAttribute($value)
    {
        $this->attributes['interests'] = is_array($value) ? implode(',', $value) : $value;
    }

    public function setSocialLinksAttribute($value)
    {
        $this->attributes['social_links'] = is_array($value) ? implode(',', $value) : $value;
    }

    /**
     * Calculate profile completion percentage
     */
    public function calculateCompletion(): int
    {
        $completedFields = 0;

        $userFields = ['name', 'email'];
        $profileFields = ['phone', 'address', 'current_job', 'company', 'bio'];
        $arrayFields = ['skills', 'interests', 'social_links'];

        foreach ($userFields as $field) {
            if (!empty($this->user->$field)) $completedFields++;
        }

        foreach ($profileFields as $field) {
            if (!empty($this->$field)) $completedFields++;
        }

        foreach ($arrayFields as $field) {
            if (!empty($this->{$field}) && count(explode(',', $this->{$field})) >= 1) {
                $completedFields++;
            }
        }

        $totalFields = count($userFields) + count($profileFields) + count($arrayFields);
        $completionPercentage = min(100, round(($completedFields / $totalFields) * 100));
        $this->profile_completion = $completionPercentage;
        $this->save();

        if ($completionPercentage === 100 && !$this->user->notifications()
            ->where('type', ProfileCompletedNotification::class)
            ->exists()) {
            $this->user->notify(new ProfileCompletedNotification());
        }

        return $completionPercentage;
    }
}
