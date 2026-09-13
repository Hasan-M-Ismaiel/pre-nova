@extends('layouts.app')

@section('title', $project->name . ' • novALight')

@section('content')

<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                {{ $project->name }}
            </h2>

            <p class="text-muted mb-0">
                Project Details
            </p>
        </div>

        @if($project->is_public)

        <a
            href="{{ route('projects.show', $project->slug) }}"
            target="_blank"
            class="btn btn-success">

            <i class="fa fa-external-link-alt me-1"></i>
            View Public Project

        </a>

        @endif
        <div class="d-flex gap-2">
            <a
                href="{{ route('admin.projects.edit', $project) }}"
                class="btn btn-primary">
                Edit Project
            </a>

            <a
                href="{{ route('admin.projects.index') }}"
                class="btn btn-outline-secondary">
                Back
            </a>
        </div>
    </div>

    {{-- Status --}}
    <div class="bg-light rounded p-4 mb-4">
        <div class="row">
            <div class="col-md-4 mb-3 mb-md-0">
                <small class="text-muted d-block">
                    Status
                </small>

                @if($project->isOpen())
                <span class="badge bg-primary">
                    Open
                </span>
                @elseif($project->isInProgress())
                <span class="badge bg-info">
                    In Progress
                </span>
                @elseif($project->isOnHold())
                <span class="badge bg-warning text-dark">
                    On Hold
                </span>
                @elseif($project->isClosed())
                <span class="badge bg-success">
                    Closed
                </span>
                @elseif($project->isCanceled())
                <span class="badge bg-danger">
                    Canceled
                </span>
                @endif
            </div>

            <div class="col-md-4 mb-3 mb-md-0">
                <small class="text-muted d-block">
                    Visibility
                </small>

                @if($project->is_public)
                <span class="badge bg-success">
                    Public
                </span>
                @else
                <span class="badge bg-secondary">
                    Private
                </span>
                @endif
            </div>

            <div class="col-md-4">
                <small class="text-muted d-block">
                    Slug
                </small>

                <span>
                    {{ $project->slug }}
                </span>
            </div>
        </div>
    </div>

    {{-- Basic Information --}}
    <div class="bg-light rounded p-4 mb-4">
        <h5 class="mb-4">
            Basic Information
        </h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <strong>
                    Client
                </strong>

                <div class="text-muted">
                    {{ $project->client_name ?? '—' }}
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <strong>
                    Industry
                </strong>

                <div class="text-muted">
                    {{ $project->industry ?? '—' }}
                </div>
            </div>

            <div class="col-12">
                <strong>
                    Description
                </strong>

                <div class="text-muted mt-1">
                    {!! nl2br(e(
                    $project->description ?? '—'
                    )) !!}
                </div>
            </div>
        </div>
    </div>

    {{-- Problem & Solution --}}
    <div class="bg-light rounded p-4 mb-4">
        <h5 class="mb-4">
            Project Strategy
        </h5>

        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <h6>
                    Problem
                </h6>

                <div class="text-muted">

                    {!! nl2br(e(
                    $project->problem ?? '—'
                    )) !!}

                </div>
            </div>

            <div class="col-md-6">
                <h6> Solution </h6>

                <div class="text-muted">
                    {!! nl2br(e(
                    $project->solution ?? '—'
                    )) !!}
                </div>
            </div>
        </div>
    </div>

    {{-- Technologies & Results --}}
    <div class="bg-light rounded p-4 mb-4">
        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <h5 class="mb-3">
                    Technologies
                </h5>

                <div class="text-muted">
                    {!! nl2br(e($project->technologies ?? '—')) !!}
                </div>
            </div>

            <div class="col-md-6">
                <h5 class="mb-3">
                    Results
                </h5>

                <div class="text-muted">
                    {!! nl2br(e($project->results ?? '—')) !!}
                </div>
            </div>
        </div>
    </div>

    {{-- Services --}}
    <div class="bg-light rounded p-4 mb-4">
        <h5 class="mb-3">
            Services
        </h5>

        @forelse($project->services as $service)
        <span class="badge bg-primary me-1 mb-1">
            {{ $service->name }}
        </span>
        @empty
        <span class="text-muted">
            No services assigned.
        </span>
        @endforelse
    </div>

    {{-- Contributors --}}
    <div class="bg-light rounded p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">
                Contributors
            </h5>

            <span class="text-muted">
                {{ $project->contributors->count() }}
            </span>
        </div>

        @forelse($project->contributors as $contributor)

        <div class="border rounded p-3 mb-3">

            <h6 class="mb-1">
                {{ $contributor->name }}
            </h6>

            <div class="text-muted mb-2">
                {{ \App\Models\Role::find($contributor->pivot->role_id)?->name ?? '—' }}
            </div>

            @if($contributor->pivot->contribution)
            <p class="mb-0">
                {{ $contributor->pivot->contribution }}
            </p>
            @endif

        </div>

        @empty

        <p class="text-muted">
            No contributors assigned yet.
        </p>

        @endforelse
    </div>

    {{-- Gallery --}}
    <div class="bg-light rounded p-4 mb-4">
        <h5 class="mb-3">
            Gallery
        </h5>

        @if($project->media->count())
        <div class="row">
            @foreach($project->media as $media)
            <div class="col-md-4 mb-3">
                <img src="{{ asset('storage/' . $media->file) }}" class="img-fluid rounded" alt="{{ $media->caption }}">

                @if($media->caption)
                <small class="text-muted d-block mt-1">
                    {{ $media->caption }}
                </small>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <p class="text-muted mb-0">
            No media uploaded yet.
        </p>
        @endif
    </div>
</div>

@endsection