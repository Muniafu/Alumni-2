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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('current_job')->nullable();
            $table->string('company')->nullable();
            $table->text('bio')->nullable();
            $table->json('social_links')->nullable();
            $table->json('skills') ->default(json_encode([]));
            $table->json('interests')->default(json_encode([]));
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
