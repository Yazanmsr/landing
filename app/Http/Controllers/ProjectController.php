<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\CvEntry;
use App\Models\LandingPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    public function update(Request $request, Project $project)
    {
        // رفع الصورة الجديدة إذا تم اختيارها
        $imagePath = $project->cvEntry->image ?? null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cv_images', 'public');
        }

        // تحديث المشروع
        $project->update([
            'title'   => $request->title,
            'slug'    => $request->slug,
            'type'    => $request->type,
            'content' => $request->content ?? null,
            'status' => 'pending', 
        ]);

        // إذا كان نوع CV، حدث بيانات الـ CV
        if ($project->type === 'cv') {
            $cv = $project->cvEntry;
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
                    'phone_number' => $request->phone_number,
                ]);
            }
        } else if ($project->type === 'landing_page') {
            $landing = $project->landingPage;

            // Handle header image
            $headerImagePath = $landing->image ?? null;

            if ($request->hasFile('header_image')) {
                $headerImagePath = $request->file('header_image')->store('landing_images', 'public');
            }

            $data = [
                'title'             => $request->header_title,
                'description'       => $request->header_description,
                'button_text'       => $request->cta_text,
                'button_link'       => $request->cta_link,
                'image'             => $headerImagePath,
                'about_title'       => $request->about_title,
                'about_description' => $request->about_description,
                'service1_title'      => $request->service1_title,
                'service1_description'=> $request->service1_description,
                'service2_title'      => $request->service2_title,
                'service2_description'=> $request->service2_description,
                'service3_title'      => $request->service3_title,
                'service3_description'=> $request->service3_description,
            ];

            if ($landing) {
                // Update existing landing page
                $landing->update($data);
            } else {
                // Create new landing page entry
                $data['project_id'] = $project->id;
                LandingPage::create($data);
            }
        }

            
        

        return redirect()->back()->with('success', 'Project updated successfully!');
    }

    public function store(Request $request)
    {
        // رفع الصورة على السيرفر (CV أو Landing Page)
        $imagePath = null;
        if ($request->hasFile('header_image')) {
            $imagePath = $request->file('header_image')->store('landing_images', 'public'); 
            // هذا سيحفظ الصورة في storage/app/public/landing_images
        } elseif ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cv_images', 'public'); 
        }

        // إنشاء المشروع
        $project = Project::create([
            'user_id' => auth()->id(),
            'title'   => $request['title'],
            'slug'    => $request['slug'],
            'type'    => $request['type'],
            'content' => $request['content'] ?? null,
            'status'  => 'approved',
        ]);

        if ($request['type'] === 'cv') {
            
            // حفظ بيانات CV
            CvEntry::create([
                'project_id'      => $project->id,
                'name'            => $request->name,
                'headline'        => $request->headline,
                'about'           => $request->about,
                'image'           => $imagePath,
                'skills'          => $request->skills,
                'work_experience' => $request->work_experience,
                'facebook_url'    => $request->facebook_url,
                'linkedin_url'    => $request->linkedin_url,
                'whatsapp_number' => $request->whatsapp_number,
                'phone_number' => $request->phone_number,
            ]);
        } elseif ($request['type'] === 'landing_page') {
            // حفظ بيانات Landing Page
            LandingPage::create([
                'project_id'        => $project->id,
                'title'             => $request->header_title,
                'description'       => $request->header_description,
                'button_text'       => $request->cta_text,
                'button_link'       => $request->cta_link,
                'image'             => $imagePath,
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
