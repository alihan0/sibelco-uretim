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
        Schema::create('form_subform_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('form');
            $table->integer('subform');
            $table->integer('align');
            $table->string('title');
            $table->string('question');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_subform_questions');
    }
};
