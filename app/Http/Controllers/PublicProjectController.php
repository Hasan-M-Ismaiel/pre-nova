<?php

namespace App\Http\Controllers;

use App\Models\Project;

class PublicProjectController extends Controller
{
    public function index()
    {
        $projects = Project::query()
            ->where('is_public', true)
            ->with([
                'services',
                'media',
            ])
            ->latest()
            ->get();

        return view(
            'projects.index',
            compact('projects')
        );
    }

    public function show(Project $project)
    {
        if (!$project->is_public) {
            abort(404);
        }

        $project->load([
            'services',
            'contributors',
            'media',
        ]);

        return view(
            'projects.show',
            compact('project')
        );
    }
}