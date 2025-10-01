<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvEntry extends Model
{
    use HasFactory;
    protected $table = 'cv_projects';


    protected $fillable = [
        'project_id',
        'name',
        'headline',
        'about',
        'image',
        'skills',
        'work_experience',
        'facebook_url',
        'linkedin_url',
        'whatsapp_number',
    ];

    protected $casts = [
        'skills'          => 'array',
        'work_experience' => 'array',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
