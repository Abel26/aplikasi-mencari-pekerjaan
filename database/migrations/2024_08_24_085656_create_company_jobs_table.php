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
        Schema::create('company_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('about');
            $table->unsignedBigInteger('salary');
            $table->string('skill_level');
            $table->string('location');
            $table->string('type');
            $table->boolean('is_open');
            $table->string('thumbnail');
            // membuat relasi field company_id table CompanyJobs ke table companies field id
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            // membuat relasi field category_id table CompanyJobs ke table categories field id
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_jobs');
    }
};
