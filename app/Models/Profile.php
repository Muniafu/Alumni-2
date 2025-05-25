<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calculateCompletion()
    {
        $totalFields = 10;
        $completedFields = 0;

        $fieldsToCheck = [
            'phone', 'address', 'current_job',
            'company', 'bio', 'social_links',
            'skills', 'interests'
        ];

        foreach ($fieldsToCheck as $field) {
            if (!empty($this->$field)) {
                $completedFields++;
            }
        }

        // Add 2 for name and profile picture (if implemented)
        if (!empty($this->user->name)) $completedFields++;
        // if ($this->user->profile_photo_path) $completedFields++;

        $this->profile_completion = round(($completedFields / $totalFields) * 100);
        $this->save();

        return $this->profile_completion;
    }
}
