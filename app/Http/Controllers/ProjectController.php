<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:projects,slug',
            'type' => 'required|in:landing_page,cv,website',
            'content' => 'nullable|string',
        ]);

        Project::create([
            'user_id' => auth()->id(), // 👈 هذا مهم جداً
            'title' => $request->title,
            'slug' => $request->slug,
            'type' => $request->type,
            'content' => $request->content,
            'status' => 'pending', // افتراضيًا يكون تحت المراجعة
        ]);

        return redirect()->back()->with('success', 'Project created successfully!');
    }
    public function show($userId, $slug)
    {
        $project = Project::where('user_id', $userId)->where('slug', $slug)->where('status', 'approved')->firstOrFail();

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
