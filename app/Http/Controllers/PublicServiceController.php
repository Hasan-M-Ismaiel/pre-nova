<?php

namespace App\Http\Controllers;

use App\Models\Service;

class PublicServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)
            ->where('show_on_website', true)
            ->orderBy('name')
            ->get();

        return view('services.index', compact('services'));
    }

    public function show(Service $service)
    {
        abort_unless(
            $service->is_active &&
            $service->show_on_website,
            404
        );

        return view('services.show', compact('service'));
    }
}