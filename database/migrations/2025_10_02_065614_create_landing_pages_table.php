<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

            $table->string('section')->default('landing'); 

            // Header
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->string('image')->nullable();

            // About
            $table->string('about_title')->nullable();
            $table->text('about_description')->nullable();

            // Services
            $table->string('service1_title')->nullable();
            $table->text('service1_description')->nullable();

            $table->string('service2_title')->nullable();
            $table->text('service2_description')->nullable();

            $table->string('service3_title')->nullable();
            $table->text('service3_description')->nullable();

            $table->integer('order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};
