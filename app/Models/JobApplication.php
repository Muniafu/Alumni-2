<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;


    protected $fillable = [
        'job_posting_id',
        'user_id',
        'cover_letter',
        'resume_path',
        'status',
        'notes',
    ];

    protected $casts = [
        'application_deadline' => 'date',
    ];

    public function job()
    {
        return $this->belongsTo(JobPosting::class, 'job_posting_id');
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'submitted' => 'Submitted',
            'reviewed' => 'Under Review',
            'interviewed' => 'Interviewing',
            'rejected' => 'Not Selected',
            'hired' => 'Hired',
        ];

        return $labels[$this->status] ?? $this->status;
    }

}
