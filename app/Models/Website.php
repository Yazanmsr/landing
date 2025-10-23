<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $table = 'websites'; // تأكد أن اسم الجدول صحيح
    protected $fillable = [
        'project_id',            // رابط المشروع الرئيسي

        // Header / Logo
        'logo_light',            // شعار الموقع
        'team_title',
        // Hero Section
        'hero_text',             // نص Hero
        'hero_image',            // صورة Hero

        // About Section
        'about_title',           // عنوان قسم About
        'about_description',     // وصف قسم About
        'about_image',           // صورة About

        // Services Section
        'services_title',        // عنوان قسم Services
        'service1_title',
        'service1_description',
        'service2_title',
        'service2_description',
        'service3_title',
        'service3_description',

        // Gallery Section
        'gallery_image1',
        'gallery_image2',
        'gallery_image3',
        'gallery_image4',

        // Team Members
        'team_member1_name',
        'team_member1_position',
        'team_member1_image',
        'team_member2_name',
        'team_member2_position',
        'team_member2_image',
        'team_member3_name',
        'team_member3_position',
        'team_member3_image',

        // Contact Section
        'contact_email_label',
        'contact_email_value',
        'contact_office_label',
        'contact_office_value',
        'contact_phone_label',
        'contact_phone_value',
        'contact_image',
        'contact_shape1',
        'contact_shape2',

        // Social Links
        'social_facebook',
        'social_linkedin',
        'social_whatsapp',
    ];


    // Cast JSON fields to array automatically
    protected $casts = [
        'nav_links' => 'array',
        'gallery_images' => 'array',
    ];

    // علاقة بالمشروع
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
