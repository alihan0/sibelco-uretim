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
        Schema::create('survey_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('user');
            $table->integer('survey');
            $table->string('key');
            $table->integer('form');
            $table->integer('question');
            $table->integer('answer');
            $table->text('note')->nullable();
            $table->string('confirm_code')->nullable();
            $table->integer('confirmative')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_answers');
    }
};
