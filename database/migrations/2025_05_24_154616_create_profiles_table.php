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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('current_job')->nullable();
            $table->string('company')->nullable();
            $table->text('bio')->nullable();

            // Comma-separated fields instead of JSON
            $table->text('skills')->nullable()->default('');
            $table->text('interests')->nullable()->default('');
            $table->text('social_links')->nullable()->default('');

            $table->unsignedTinyInteger('profile_completion')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
