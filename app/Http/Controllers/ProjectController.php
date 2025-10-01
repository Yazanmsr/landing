<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\CvEntry;
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
                ]);
            } else {
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
                ]);
            }
        }

        return redirect()->back()->with('success', 'Project updated successfully!');
    }

    public function store(Request $request)
    {

        // رفع الصورة على السيرفر
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cv_images', 'public'); 
            // هذا سيحفظ الصورة في storage/app/public/cv_images
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

        // إذا كان نوع CV، احفظ بيانات الـ CV
        if ($request['type'] === 'cv') {
            CvEntry::create([
                'project_id'      => $project->id,
                'name'            => $request->name,
                'headline'        => $request->headline,
                'about'           => $request->about,
                'image'           => $imagePath, // مسار الصورة المخزن
                'skills'          => $request->skills, // مصفوفة أو JSON
                'work_experience' => $request->work_experience,
                'facebook_url'    => $request->facebook_url,
                'linkedin_url'    => $request->linkedin_url,
                'whatsapp_number' => $request->whatsapp_number,
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

        $project = Project::where('user_id', $userId)
            ->where('slug', $slug)
            ->when(!Gate::allows('is-admin'), function($query) {
                $query->where('status', 'approved');
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
