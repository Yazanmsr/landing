<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',              // Header H1
        'description',        // Header paragraph
        'button_text',        // CTA text
        'button_link',        // CTA link
        'image',              // Header image

        'about_title',        // About H2
        'about_description',  // About paragraph
        'services_heading',
        'service1_title',
        'service1_description',

        'service2_title',
        'service2_description',

        'service3_title',
        'service3_description',

        'order',
    ];

    // علاقة مع المشروع
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
