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
        Schema::create('survey_draft_subform_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('user');
            $table->string('key');
            $table->integer('subform');
            $table->integer('question');
            $table->integer('answer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_draft_subform_answers');
    }
};
