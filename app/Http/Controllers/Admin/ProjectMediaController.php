<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectMediaController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'file' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp,gif',
                'max:5120',
            ],

            'caption' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $path = $request->file('file')->store('projects/' . $project->id, 'public');

        $sortOrder = ($project->media()->max('sort_order') ?? -1) + 1;

        $project->media()->create([
            'file' => $path,
            'caption' => $validated['caption'] ?? null,
            'sort_order' => $sortOrder,
        ]);

        return back()->with(
            'success',
            'Project media uploaded successfully.'
        );
    }

    public function update(
        Request $request,
        Project $project,
        ProjectMedia $media
    ) {
        abort_unless(
            $media->project_id === $project->id,
            404
        );

        $validated = $request->validate([
            'caption' => [
                'nullable',
                'string',
                'max:255',
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:0',
            ],
        ]);

        $media->update([
            'caption' => $validated['caption'] ?? null,
            'sort_order' => $validated['sort_order'],
        ]);

        return back()->with(
            'success',
            'Project media updated successfully.'
        );
    }

    public function destroy(
        Project $project,
        ProjectMedia $media
    ) {
        abort_unless(
            $media->project_id === $project->id,
            404
        );

        if ($media->file) {
            Storage::disk('public')->delete($media->file);
        }

        $media->delete();

        return back()->with(
            'success',
            'Project media deleted successfully.'
        );
    }
}