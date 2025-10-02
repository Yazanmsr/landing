<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'slug',
        'content',
        'status',
    ];

    // علاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة مع CV إذا كان نوع المشروع cv
    public function cvEntry()
    {
        return $this->hasOne(CvEntry::class);
    }

    // علاقة مع Landing Page إذا كان نوع المشروع landing_page
    public function landingPage()
    {
        return $this->hasOne(LandingPage::class);
    }

    // علاقة مع Website إذا كان نوع المشروع website
    public function website()
    {
        return $this->hasOne(Website::class);
    }

    // مساعدة لمعرفة النوع الحالي
    public function isCv()
    {
        return $this->type === 'cv';
    }

    public function isLandingPage()
    {
        return $this->type === 'landing_page';
    }

    public function isWebsite()
    {
        return $this->type === 'website';
    }
}
