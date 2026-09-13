<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();

        return view(
            'admin.services.index',
            compact('services')
        );
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
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
                'unique:services,slug',
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            'show_on_website' => [
                'nullable',
                'boolean',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $slug = $validated['slug']
            ?? Str::slug($validated['name']);

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image')
                ->store('services', 'public');
        }

        Service::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'short_description' =>
            $validated['short_description'] ?? null,
            'description' =>
            $validated['description'] ?? null,
            'is_active' =>
            $request->boolean('is_active'),
            'show_on_website' =>
            $request->boolean('show_on_website'),
            'image' => $image,
        ]);

        return redirect()
            ->route('admin.services.index')
            ->with(
                'success',
                'Service created successfully.'
            );
    }

    public function edit(Service $service)
    {
        return view(
            'admin.services.edit',
            compact('service')
        );
    }

    public function update(Request $request, Service $service)
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
                'unique:services,slug,' . $service->id,
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            'show_on_website' => [
                'nullable',
                'boolean',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $serviceData = [
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'show_on_website' => $request->boolean('show_on_website'),
        ];

        if ($request->hasFile('image')) {

            if ($service->image) {
                Storage::disk('public')->delete(
                    $service->image
                );
            }

            $serviceData['image'] = $request->file('image')
                ->store('services', 'public');
        }

        $service->update($serviceData);

        $service->update([
            'name' => $validated['name'],

            'slug' => $validated['slug']
                ?? Str::slug($validated['name']),

            'short_description' =>
            $validated['short_description'] ?? null,

            'description' =>
            $validated['description'] ?? null,

            'is_active' =>
            $request->boolean('is_active'),

            'show_on_website' =>
            $request->boolean('show_on_website'),
        ]);

        return redirect()
            ->route(
                'admin.services.index'
            )
            ->with(
                'success',
                'Service updated successfully.'
            );
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with(
                'success',
                'Service deleted successfully.'
            );
    }
}
