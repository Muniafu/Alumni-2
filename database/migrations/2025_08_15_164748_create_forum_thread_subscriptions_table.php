<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forum_thread_subscriptions', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('thread_id');
            $table->unsignedBigInteger('user_id');

            $table->timestamps();

            // Correct foreign key references
            $table->foreign('thread_id')
                  ->references('id')
                  ->on('forum_threads') // matches your existing table name
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            // Optional: prevent duplicates (user subscribing to same thread multiple times)
            $table->unique(['thread_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forum_thread_subscriptions');
    }
};
