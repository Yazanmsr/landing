<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\GoogleController;
    
use Illuminate\Http\Request;

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/'); // رجوع للصفحة الرئيسية أو صفحة تسجيل الدخول
})->name('logout');

// Logout
Route::get('/logout', function() {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Google login routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/dashboard/super-admin', function () {
    $user = auth()->user();
    if ($user->role === 'user') {
        return view('dashboard.user', compact('user'));
    }
    return view('dashboard.super_admin', compact('user'));
})->middleware('auth')->name('dashboard.super_admin');
use App\Models\Project;

Route::get('/dashboard/super-admin', function () {
    $user = auth()->user();

    // جلب كل المشاريع
    $projects = Project::with('user')->orderBy('created_at', 'desc')->get();

    return view('dashboard.super_admin', compact('user', 'projects'));
})->middleware('auth')->name('dashboard.super_admin');

Route::get('/dashboard/user', function () {
    $user = auth()->user();
    return view('dashboard.user', compact('user'));
})->middleware('auth')->name('dashboard.user');



use App\Http\Controllers\ProjectController;

Route::post('/projects', [ProjectController::class, 'store'])
    ->middleware('auth')
    ->name('projects.store');
Route::get('/user/{user}/{slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::middleware(['auth','can:is-admin'])->group(function () {
    Route::post('/projects/{project}/approve', [ProjectController::class, 'approve'])->name('projects.approve');
    Route::post('/projects/{project}/reject', [ProjectController::class, 'reject'])->name('projects.reject');

    Route::delete('/projects/{project}/delete', [ProjectController::class, 'destroy'])->name('projects.delete');
});


Route::middleware('auth')->group(function () {
    // عرض كل مشاريع المستخدم
    Route::get('/pages', function () {
        $user = auth()->user();
        $projects = Project::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('dashboard.pages', compact('user', 'projects'));
    })->name('pages');

    // إنشاء مشروع جديد
    Route::post('/pages', function (Request $request) {
        $request->validate([
            'type' => 'required|in:landing_page,cv,website',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:projects,slug',
            'content' => 'nullable|string',
        ]);

        Project::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Project created successfully.');
    })->name('pages.store');

    // تعديل مشروع
    Route::post('/pages/{project}/update', function (Request $request, Project $project) {
        $thisUser = auth()->id();
        if ($project->user_id !== $thisUser) abort(403);

        $request->validate([
            'type' => 'required|in:landing_page,cv,website',
            'title' => 'required|string|max:255',
            'slug' => "required|string|max:255|unique:projects,slug,{$project->id}",
            'content' => 'nullable|string',
        ]);

        $project->update($request->all());
        return redirect()->back()->with('success', 'Project updated successfully.');
    })->name('pages.update');

    // حذف مشروع
    Route::delete('/pages/{project}', function (Project $project) {
        if ($project->user_id !== auth()->id()) abort(403);
        $project->delete();
        return redirect()->back()->with('success', 'Project deleted successfully.');
    })->name('pages.delete');
});
Route::get('/user/{user_id}/{slug}', function ($user_id, $slug) {
    $project = Project::where('user_id', $user_id)
                      ->where('slug', $slug)
                      ->where('status', 'approved') // فقط المشاريع المقبولة
                      ->firstOrFail();

    return view('projects.show', compact('project'));
})->name('projects.show.public');


Route::post('/projects/{project}/approve', [ProjectController::class, 'approve'])
    ->name('projects.approve')
    ->middleware('auth');
Route::post('/projects/{project}/reject', [ProjectController::class, 'reject'])
    ->name('projects.reject')
    ->middleware('auth');
Route::get('/', function () {
    $user = auth()->user();
    

    if ($user && $user->role === 'user') {
        $projects = Project::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('dashboard.user', compact('user'));
    }
    else if(!$user) {
        return view('welcome');
    }
    $projects = Project::orderBy('created_at', 'desc')->get();
    return view('dashboard.super_admin', compact('user', 'projects'));
});


use App\Http\Controllers\UserController;

Route::middleware(['auth', 'can:is-admin'])->group(function () {
    Route::resource('users', UserController::class);
});
Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');

// Route to update an existing project
Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
