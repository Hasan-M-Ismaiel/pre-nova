<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('services')
            ->latest()
            ->get();

        return view(
            'admin.projects.index',
            compact('projects')
        );
    }

    public function create()
    {
        $services = Service::where('is_active', true)
            ->orderBy('name')
            ->get();

        $specialists = User::orderBy('name')->get();

        $roles = Role::orderBy('name')->get();

        $proposal = null;

        return view('admin.projects.create', compact(
            'services',
            'specialists',
            'roles',
            'proposal'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'proposal_id' => [
                'nullable',
                'integer',
                'exists:proposals,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:projects,slug',
            ],

            'client_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'industry' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'problem' => [
                'nullable',
                'string',
            ],

            'solution' => [
                'nullable',
                'string',
            ],

            'technologies' => [
                'nullable',
                'string',
            ],

            'results' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:open,in_progress,on_hold,closed,canceled',
            ],

            'is_public' => [
                'nullable',
                'boolean',
            ],

            'services' => [
                'nullable',
                'array',
            ],

            'services.*' => [
                'integer',
                'exists:services,id',
            ],
            'contributors' => ['nullable', 'array'],

            'contributors.*.specialist_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],

            'contributors.*.role_id' => [
                'required',
                'integer',
                'exists:roles,id',
            ],

            'contributors.*.contribution' => [
                'nullable',
                'string',
            ],
            'media' => [
                'nullable',
                'array',
            ],

            'media.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp,gif',
                'max:5120',
            ],
        ]);

        $proposal = null;

        if (!empty($validated['proposal_id'])) {

            $proposal = Proposal::findOrFail(
                $validated['proposal_id']
            );

            if ($proposal->status !== 'approved') {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Only approved proposals can be converted into projects.'
                    );
            }

            if ($proposal->project_id) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'This proposal has already been converted into a project.'
                    );
            }
        }
        $project = Project::create([
            'name' => $validated['name'],

            'slug' => $validated['slug']
                ?? Str::slug($validated['name']),

            'client_name' =>
            $validated['client_name'] ?? null,

            'industry' =>
            $validated['industry'] ?? null,

            'description' =>
            $validated['description'] ?? null,

            'problem' =>
            $validated['problem'] ?? null,

            'solution' =>
            $validated['solution'] ?? null,

            'technologies' =>
            $validated['technologies'] ?? null,

            'results' =>
            $validated['results'] ?? null,

            'status' =>
            $validated['status'],

            'is_public' =>
            $request->boolean('is_public'),
        ]);

        $project->services()->sync($validated['services'] ?? []);

        $project->contributors()->detach();

        foreach ($validated['contributors'] ?? [] as $contributor) {

            $project->contributors()->attach(
                $contributor['specialist_id'],
                [
                    'role_id' => $contributor['role_id'],
                    'contribution' => $contributor['contribution'] ?? null,
                ]
            );
        }

        if ($request->hasFile('media')) {

            foreach ($request->file('media') as $index => $file) {

                $path = $file->store(
                    'projects/' . $project->id,
                    'public'
                );

                $project->media()->create([
                    'file' => $path,
                    'caption' => null,
                    'sort_order' => $index,
                ]);
            }
        }

        if ($proposal) {
            $proposal->update([
                'project_id' => $project->id,
            ]);
        }

        return redirect()
            ->route('admin.projects.index')
            ->with(
                'success',
                'Project created successfully.'
            );
    }

    public function show(Project $project)
    {
        $project->load([
            'services',
            'contributors',
            'media',
        ]);

        return view(
            'admin.projects.show',
            compact('project')
        );
    }

    public function edit(Project $project)
    {
        $services = Service::where('is_active', true)
            ->orderBy('name')
            ->get();

        $specialists = User::orderBy('name')->get();

        $roles = Role::orderBy('name')->get();

        $project->load([
            'services',
            'contributors',
            'media',
        ]);

        return view('admin.projects.edit', compact(
            'project',
            'services',
            'specialists',
            'roles'
        ));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:projects,slug,' . $project->id,
            ],

            'client_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'industry' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'problem' => [
                'nullable',
                'string',
            ],

            'solution' => [
                'nullable',
                'string',
            ],

            'technologies' => [
                'nullable',
                'string',
            ],

            'results' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:open,in_progress,on_hold,closed,canceled',
            ],

            'is_public' => [
                'nullable',
                'boolean',
            ],

            'services' => [
                'nullable',
                'array',
            ],

            'services.*' => [
                'integer',
                'exists:services,id',
            ],
            'contributors' => ['nullable', 'array'],

            'contributors.*.specialist_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],

            'contributors.*.role_id' => [
                'required',
                'integer',
                'exists:roles,id',
            ],

            'contributors.*.contribution' => [
                'nullable',
                'string',
            ],
        ]);

        $project->update([
            'name' => $validated['name'],

            'slug' => $validated['slug']
                ?? Str::slug($validated['name']),

            'client_name' =>
            $validated['client_name'] ?? null,

            'industry' =>
            $validated['industry'] ?? null,

            'description' =>
            $validated['description'] ?? null,

            'problem' =>
            $validated['problem'] ?? null,

            'solution' =>
            $validated['solution'] ?? null,

            'technologies' =>
            $validated['technologies'] ?? null,

            'results' =>
            $validated['results'] ?? null,

            'status' =>
            $validated['status'],

            'is_public' =>
            $request->boolean('is_public'),
        ]);

        $project->services()->sync(
            $validated['services'] ?? []
        );

        $project->contributors()->detach();

        foreach ($validated['contributors'] ?? [] as $contributor) {

            $project->contributors()->attach(
                $contributor['specialist_id'],
                [
                    'role_id' => $contributor['role_id'],
                    'contribution' => $contributor['contribution'] ?? null,
                ]
            );
        }

        return redirect()
            ->route(
                'admin.projects.index'
            )
            ->with(
                'success',
                'Project updated successfully.'
            );
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with(
                'success',
                'Project deleted successfully.'
            );
    }

    public function createFromProposal(Proposal $proposal)
    {
        if ($proposal->status !== 'approved') {
            return redirect()
                ->route('admin.proposals.show', $proposal)
                ->with(
                    'error',
                    'Only approved proposals can be converted into projects.'
                );
        }

        if ($proposal->project_id) {
            return redirect()
                ->route('admin.proposals.show', $proposal)
                ->with(
                    'info',
                    'This proposal has already been converted into a project.'
                );
        }

        $services = Service::where('is_active', true)
            ->orderBy('name')
            ->get();

        $specialists = User::orderBy('name')->get();

        $roles = Role::orderBy('name')->get();

        return view('admin.projects.create', compact(
            'services',
            'specialists',
            'roles',
            'proposal'
        ));
    }
}
