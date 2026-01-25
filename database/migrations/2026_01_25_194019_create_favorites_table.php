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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('anime_id');
            $table->string('title');
            $table->string('image_url');
            $table->decimal('score', 3, 1)->nullable();
            $table->enum('status', ['Watching', 'Completed', 'Plan to Watch'])->default('Plan to Watch');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'anime_id']); // Prevent duplicate favorites for same user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
