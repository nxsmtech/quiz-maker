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
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('question');
            $table->string('background_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('total_votes_text')->nullable();
            $table->string('button_color')->nullable();
            $table->string('button_text_color')->nullable();
            $table->string('background_image')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(false);
            $table->string('button_text')->nullable();
            $table->string('results_title')->nullable();
            $table->text('results_summary')->nullable();
            $table->integer('version')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('polls');
    }
};
