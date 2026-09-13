<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SpecialistController extends Controller
{
    /**
     * Display all specialists.
     */
    public function index()
    {
        $specialists = User::where('role', 'specialist')
            ->with([
                'specialistProfile',
                'roles',
            ])
            ->latest()
            ->get();

        return view('admin.specialists.index', compact('specialists'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $roles = Role::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.specialists.create', compact('roles'));
    }

    /**
     * Store specialist.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'headline' => [
                'nullable',
                'string',
                'max:255',
            ],

            'bio' => [
                'nullable',
                'string',
            ],

            'is_available' => [
                'nullable',
                'boolean',
            ],

            'roles' => [
                'nullable',
                'array',
            ],

            'roles.*' => [
                'exists:roles,id',
            ],

            'show_on_website' => [
                'nullable',
                'boolean',
            ],
            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $specialist = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'specialist',
        ]);

        $profileImage = null;

        if ($request->hasFile('profile_image')) {

            $profileImage = $request->file('profile_image')
                ->store('specialists', 'public');
        }

        $specialist->specialistProfile()->create([
            'headline' => $validated['headline'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'profile_image' => $profileImage,
            'is_available' => $request->boolean('is_available'),
            'show_on_website' => $request->boolean('show_on_website'),
        ]);

        $specialist->roles()->sync(
            $validated['roles'] ?? []
        );

        return redirect()
            ->route('admin.specialists.index')
            ->with('success', 'Specialist created successfully.');
    }

    /**
     * Show specialist profile.
     */
    public function show(User $specialist)
    {
        abort_unless(
            $specialist->role === 'specialist',
            404
        );

        $specialist->load([
            'specialistProfile',
            'roles',
            'projects',
        ]);

        return view(
            'admin.specialists.show',
            compact('specialist')
        );
    }

    /**
     * Show edit form.
     */
    public function edit(User $specialist)
    {
        abort_unless(
            $specialist->role === 'specialist',
            404
        );

        $specialist->load([
            'specialistProfile',
            'roles',
        ]);

        $roles = Role::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.specialists.edit',
            compact('specialist', 'roles')
        );
    }

    /**
     * Update specialist.
     */
    public function update(Request $request, User $specialist)
    {
        abort_unless(
            $specialist->role === 'specialist',
            404
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $specialist->id,
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'headline' => [
                'nullable',
                'string',
                'max:255',
            ],

            'bio' => [
                'nullable',
                'string',
            ],

            'is_available' => [
                'nullable',
                'boolean',
            ],

            'roles' => [
                'nullable',
                'array',
            ],

            'roles.*' => [
                'exists:roles,id',
            ],

            'show_on_website' => [
                'nullable',
                'boolean',
            ],
            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $specialist->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (!empty($validated['password'])) {
            $specialist->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        $profile = $specialist->specialistProfile;

        $profileData = [
            'headline' => $validated['headline'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'is_available' => $request->boolean('is_available'),
            'show_on_website' => $request->boolean('show_on_website'),
        ];

        if ($request->hasFile('profile_image')) {

            if ($profile?->profile_image) {
                Storage::disk('public')->delete(
                    $profile->profile_image
                );
            }

            $profileData['profile_image'] = $request->file('profile_image')
                ->store('specialists', 'public');
        }

        $specialist->specialistProfile()->updateOrCreate(
            [
                'user_id' => $specialist->id,
            ],
            $profileData
        );

        $specialist->specialistProfile()->updateOrCreate(
            [
                'user_id' => $specialist->id,
            ],
            [
                'headline' => $validated['headline'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'is_available' => $request->boolean('is_available'),
                'show_on_website' => $request->boolean('show_on_website'),
            ]
        );

        $specialist->roles()->sync(
            $validated['roles'] ?? []
        );

        return redirect()
            ->route(
                'admin.specialists.show',
                $specialist
            )
            ->with('success', 'Specialist updated successfully.');
    }

    /**
     * Delete specialist.
     */
    public function destroy(User $specialist)
    {
        abort_unless(
            $specialist->role === 'specialist',
            404
        );

        $specialist->delete();

        return redirect()
            ->route('admin.specialists.index')
            ->with('success', 'Specialist deleted successfully.');
    }
}
