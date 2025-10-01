<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cv_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

            // من الـ template
            $table->string('name')->nullable();
            $table->string('headline')->nullable();
            $table->text('about')->nullable();
            $table->string('image')->nullable();

            // JSON لحفظ القوائم
            $table->json('skills')->nullable();
            $table->json('work_experience')->nullable();

            // روابط السوشال
            $table->string('facebook_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('whatsapp_number')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_projects');
    }
};
