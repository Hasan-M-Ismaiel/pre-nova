<?php

namespace App\Http\Controllers;

use App\Models\User;

class SpecialistController extends Controller
{
    /**
     * Display all public specialists.
     */
    public function index()
    {
        $specialists = User::where('role', 'specialist')
            ->whereHas('specialistProfile', function ($query) {
                $query->where('show_on_website', true);
            })
            ->with([
                'specialistProfile',
                'roles',
            ])
            ->latest()
            ->get();

        return view(
            'specialists.index',
            compact('specialists')
        );
    }

    /**
     * Display one public specialist profile.
     */
    public function show(User $specialist)
    {
        abort_unless(
            $specialist->role === 'specialist',
            404
        );

        abort_unless(
            $specialist->specialistProfile?->show_on_website,
            404
        );

        $specialist->load([
            'specialistProfile',
            'roles',
            'projects',
        ]);

        return view(
            'specialists.show',
            compact('specialist')
        );
    }
}