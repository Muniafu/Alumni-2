<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['job', 'internship', 'mentorship']);
            $table->string('company');
            $table->string('location');
            $table->boolean('is_remote')->default(false);
            $table->string('salary_range')->nullable();
            $table->string('employment_type')->nullable();
            $table->date('application_deadline')->nullable();
            $table->string('contact_email');
            $table->string('contact_phone')->nullable();
            $table->string('website')->nullable();
            $table->json('skills_required')->nullable();
            $table->json('skills_preferred')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_posting_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('cover_letter');
            $table->string('resume_path');
            $table->enum('status', ['submitted', 'reviewed', 'interviewed', 'rejected', 'hired'])->default('submitted');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['job_posting_id', 'user_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_postings');
        Schema::dropIfExists('job_applications');
    }
};
