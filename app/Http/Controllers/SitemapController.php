<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Project;

class SitemapController extends Controller
{
    public function index()
    {
        $projects = Project::where('status', 'approved')->get();

        $baseUrl = config('app.url') . '/user';

        $xml = view('sitemap', compact('projects', 'baseUrl'));

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}
