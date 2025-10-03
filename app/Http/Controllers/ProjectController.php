<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\CvEntry;
use App\Models\LandingPage;
use App\Models\Website;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
public function update(Request $request, Project $project)
{
    // --- Update main project ---
    $project->update([
        'title'   => $request->title,
        'slug'    => $request->slug,
        'type'    => $request->type,
        'content' => $request->content ?? null,
        'status'  => 'pending',
    ]);

    // --- Handle CV ---
    if ($project->type === 'cv') {
        $cv = $project->cvEntry;

        $imagePath = $cv->image ?? null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cv_images', 'public');
        }

        if ($cv) {
            $cv->update([
                'name'            => $request->name,
                'headline'        => $request->headline,
                'about'           => $request->about,
                'image'           => $imagePath,
                'skills'          => $request->skills,
                'work_experience' => $request->work_experience,
                'facebook_url'    => $request->facebook_url,
                'linkedin_url'    => $request->linkedin_url,
                'whatsapp_number' => $request->whatsapp_number,
            ]);
        }
    } 
    
    // --- Handle Landing Page ---
    else if ($project->type === 'landing_page') {
        $landing = $project->landingPage;

        $headerImagePath = $landing->image ?? null;
        if ($request->hasFile('header_image')) {
            $headerImagePath = $request->file('header_image')->store('landing_images', 'public');
        }

        $data = [
            'title'               => $request->header_title,
            'description'         => $request->header_description,
            'button_text'         => $request->cta_text,
            'button_link'         => $request->cta_link,
            'image'               => $headerImagePath,
            'about_title'         => $request->about_title,
            'about_description'   => $request->about_description,
            'service1_title'      => $request->service1_title,
            'service1_description'=> $request->service1_description,
            'service2_title'      => $request->service2_title,
            'service2_description'=> $request->service2_description,
            'service3_title'      => $request->service3_title,
            'service3_description'=> $request->service3_description,
        ];

        if ($landing) {
            $landing->update($data);
        } else {
            $data['project_id'] = $project->id;
            LandingPage::create($data);
        }
    } 
    
    // --- Handle Website ---
    else if ($project->type === 'website') {
        $website = $project->website;

        $files = [
            'logo_light', 'hero_image', 'about_image',
            'team_member1_image','team_member2_image','team_member3_image',
            'gallery_image1','gallery_image2','gallery_image3','gallery_image4',
            'contact_image'
        ];

        $data = [];

        // Handle all uploaded images
        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $data[$file] = $request->file($file)->store('website_images', 'public');
            } elseif ($website) {
                $data[$file] = $website->$file ?? null;
            }
        }

        // Text fields
        $textFields = [
            'hero_text','about_title','about_description',
            'team_member1_name','team_member1_position',
            'team_member2_name','team_member2_position',
            'team_member3_name','team_member3_position',
            'services_title','service1_title','service1_description',
            'service2_title','service2_description','service3_title','service3_description',
            'contact_email_label','contact_email_value',
            'contact_office_label','contact_office_value',
            'contact_phone_label','contact_phone_value','team_title',
            'social_facebook','social_linkedin','social_whatsapp'
        ];

        foreach ($textFields as $field) {
            $data[$field] = $request->$field ?? ($website->$field ?? null);
        }

        if ($website) {
            $website->update($data);
        } else {
            $data['project_id'] = $project->id;
            Website::create($data);
        }
    }

    return redirect()->back()->with('success', 'Project updated successfully!');
}


    public function store(Request $request)
    {
        $imagePaths = [];

        $imageFields = [
            'header_image','image',
            'hero_image','about_image','contact_image',
            'team_member1_image','team_member2_image','team_member3_image',
            'gallery_image1','gallery_image2','gallery_image3','gallery_image4'
        ];

        foreach($imageFields as $field) {
            if ($request->hasFile($field)) {
                // تحديد المجلد حسب الحقل
                if($field === 'image') {
                    $folder = 'cv_images';
                } elseif($field === 'header_image') {
                    $folder = 'landing_images';
                } elseif(in_array($field, ['hero_image','about_image','contact_image'])) {
                    $folder = 'website_images';
                } elseif(in_array($field, ['team_member1_image','team_member2_image','team_member3_image'])) {
                    $folder = 'team_images';
                } elseif(in_array($field, ['gallery_image1','gallery_image2','gallery_image3','gallery_image4'])) {
                    $folder = 'gallery_images';
                } else {
                    $folder = 'other_images';
                }

                $imagePaths[$field] = $request->file($field)->store($folder, 'public');
            }
        }


        // إنشاء المشروع
        $project = Project::create([
            'user_id' => auth()->id(),
            'title'   => $request['title'],
            'slug'    => $request['slug'],
            'type'    => $request['type'],
            'content' => $request['content'] ?? null,
            'status'  => 'pending',
        ]);

        if ($request['type'] === 'cv') {
            CvEntry::create([
                'project_id'      => $project->id,
                'name'            => $request->name,
                'headline'        => $request->headline,
                'about'           => $request->about,
                'image'           => $imagePaths['image'] ?? null,
                'skills'          => $request->skills,
                'work_experience' => $request->work_experience,
                'facebook_url'    => $request->facebook_url,
                'linkedin_url'    => $request->linkedin_url,
                'whatsapp_number' => $request->whatsapp_number,
            ]);
        } elseif ($request['type'] === 'landing_page') {
            LandingPage::create([
                'project_id'        => $project->id,
                'title'             => $request->header_title,
                'description'       => $request->header_description,
                'button_text'       => $request->cta_text,
                'button_link'       => $request->cta_link,
                'image'             => $imagePaths['header_image'] ?? null,
                'services_heading'  => $request->services_heading,                
                'about_title'       => $request->about_title,
                'about_description' => $request->about_description,
                'service1_title'    => $request->service1_title,
                'service1_description' => $request->service1_description,
                'service2_title'    => $request->service2_title,
                'service2_description' => $request->service2_description,
                'service3_title'    => $request->service3_title,
                'service3_description' => $request->service3_description,
            ]);
        } elseif ($request['type'] === 'website') {
            // حفظ بيانات Website
                Website::create([
                    'project_id'        => $project->id,
                    'logo_light'        => $imagePaths['logo_light'] ?? null,

                    // Hero Section
                    'hero_image'        => $imagePaths['hero_image'] ?? null,
                    'hero_text'         => $request->hero_text,

                    // About Section
                    'about_title'       => $request->about_title,
                    
                    'about_image'       => $imagePaths['about_image'] ?? null,

                    // Team Members
                    
                    'team_title' => $request->team_title,
                    'team_member1_name'     => $request->team_member1_name,
                    'team_member1_position' => $request->team_member1_position,
                    'team_member1_image'    => $imagePaths['team_member1_image'] ?? null,

                    'team_member2_name'     => $request->team_member2_name,
                    'team_member2_position' => $request->team_member2_position,
                    'team_member2_image'    => $imagePaths['team_member2_image'] ?? null,

                    'team_member3_name'     => $request->team_member3_name,
                    'team_member3_position' => $request->team_member3_position,
                    'team_member3_image'    => $imagePaths['team_member3_image'] ?? null,

                    // Services Section
                    'services_title'       => $request->services_title,
                    'service1_title'       => $request->service1_title,
                    'service1_description' => $request->service1_description,
                    'service2_title'       => $request->service2_title,
                    'service2_description' => $request->service2_description,
                    'service3_title'       => $request->service3_title,
                    'service3_description' => $request->service3_description,

                    // Gallery Section
                    'gallery_image1' => $imagePaths['gallery_image1'] ?? null,
                    'gallery_image2' => $imagePaths['gallery_image2'] ?? null,
                    'gallery_image3' => $imagePaths['gallery_image3'] ?? null,
                    'gallery_image4' => $imagePaths['gallery_image4'] ?? null,

                    // Contact Section
                    'contact_email_label'  => $request->contact_email_label,
                    'contact_email_value'  => $request->contact_email_value,
                    'contact_office_label' => $request->contact_office_label,
                    'contact_office_value' => $request->contact_office_value,
                    'contact_phone_label'  => $request->contact_phone_label,
                    'contact_phone_value'  => $request->contact_phone_value,
                    'contact_image'        => $imagePaths['contact_image'] ?? null,
                    'contact_shape1'       => $imagePaths['contact_shape1'] ?? null,
                    'contact_shape2'       => $imagePaths['contact_shape2'] ?? null,

                    // Social Links
                    'social_facebook' => $request->social_facebook,
                    'social_linkedin' => $request->social_linkedin,
                    'social_whatsapp' => $request->social_whatsapp,
                ]);


                
        }

        return redirect()->back()->with('success', 'Project created successfully!');
    }


    public function edit(Project $project)
    {
        // يمكنك إعادة استخدام نفس view الـ create مع تمرير $project
        $user = auth()->user(); // أو أي طريقة للحصول على المستخدم الحالي
        return view('dashboard.user', compact('project', 'user'));
    }


    public function show($userId, $slug)
    {
        $user = Auth::user();

        if (!$user){
            die("<h1>please wait to be approved by admin</h1>");
        }

        $project = Project::where('slug', $slug)
            ->where(function($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhere('status', 'approved');
            })
            ->firstOrFail();


        return view('projects.show', compact('project'));
    }



    public function approve(Project $project)
    {
        // تحقق من صلاحية المستخدم (مثلاً super_admin)
        if(auth()->user()->role !== 'super_admin') {
            abort(403);
        }
        
        $project->status = 'approved';
        $project->save();

        return redirect()->back()->with('success', 'Project approved successfully!');
    }

    // دالة رفض المشروع
    public function reject(Project $project)
    {
        if(auth()->user()->role !== 'super_admin') {
            abort(403);
        }

        $project->status = 'rejected';
        $project->save();

        return redirect()->back()->with('success', 'Project rejected!');
    }
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->back()->with('success', 'Project deleted successfully!');
    }


}
