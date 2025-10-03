<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            // Header / Logo
            $table->string('logo_light')->nullable();

            // Hero Section
            $table->string('hero_image')->nullable(); // Woman image
            $table->text('hero_text')->nullable(); // H1 text

            // About Section
            $table->text('about_title')->nullable(); // About Us
            $table->text('about_description')->nullable(); // paragraph
            $table->string('about_image')->nullable();

            // Team Members (3 members)
            $table->string('team_title')->nullable();
            $table->string('team_member1_image')->nullable();
            $table->string('team_member1_name')->nullable();
            $table->string('team_member1_position')->nullable();

            $table->string('team_member2_image')->nullable();
            $table->string('team_member2_name')->nullable();
            $table->string('team_member2_position')->nullable();

            $table->string('team_member3_image')->nullable();
            $table->string('team_member3_name')->nullable();
            $table->string('team_member3_position')->nullable();

            // Services Section
            $table->text('services_title')->nullable(); // "Services"

            // Service 1
            $table->string('service1_title')->nullable();
            $table->text('service1_description')->nullable();

            // Service 2
            $table->string('service2_title')->nullable();
            $table->text('service2_description')->nullable();

            // Service 3
            $table->string('service3_title')->nullable();
            $table->text('service3_description')->nullable();

            // Gallery Section - 4 images
            $table->string('gallery_image1')->nullable();
            $table->string('gallery_image2')->nullable();
            $table->string('gallery_image3')->nullable();
            $table->string('gallery_image4')->nullable();

            // Contact Section
            $table->string('contact_email_label')->nullable();
            $table->string('contact_email_value')->nullable();

            $table->string('contact_office_label')->nullable();
            $table->string('contact_office_value')->nullable();

            $table->string('contact_phone_label')->nullable();
            $table->string('contact_phone_value')->nullable();

            $table->string('social_facebook')->nullable();
            $table->string('social_linkedin')->nullable();
            $table->string('social_whatsapp')->nullable();

            $table->string('contact_image')->nullable();
            $table->string('contact_shape1')->nullable();
            $table->string('contact_shape2')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
