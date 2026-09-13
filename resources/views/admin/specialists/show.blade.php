@extends('layouts.app')

@section('title', $specialist->name . ' • novALight')

@section('content')

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>{{ $specialist->name }}</h2>

            @if($specialist->specialistProfile?->headline)
            <p class="text-muted mb-0">
                {{ $specialist->specialistProfile->headline }}
            </p>
            @endif
        </div>

        <div>
            <a
                href="{{ route('admin.specialists.edit', $specialist) }}"
                class="btn btn-primary">
                Edit
            </a>

            <a
                href="{{ route('admin.specialists.index') }}"
                class="btn btn-outline-secondary">
                Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Profile --}}
        <div class="col-md-8">
            <div class="bg-light rounded p-4 h-100">
                <h5 class="mb-3">
                    Profile
                </h5>

                {{-- Profile Image --}}
                @if($specialist->specialistProfile?->profile_image)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $specialist->specialistProfile->profile_image) }}" alt="{{ $specialist->name }}" class="rounded-circle" style=" width: 150px; height: 150px; object-fit: cover; ">
                </div> @endif

                @if($specialist->specialistProfile?->bio)
                <p> {{ $specialist->specialistProfile->bio }}</p>
                @else

                <p class="text-muted">
                    No bio available.
                </p>
                @endif

                <hr>

                <h6>
                    Roles
                </h6>

                @forelse($specialist->roles as $role)
                <span class="badge bg-secondary me-1">
                    {{ $role->name }}
                </span>
                @empty
                <p class="text-muted">
                    No roles assigned.
                </p>
                @endforelse
            </div>
        </div>

        {{-- Status --}}
        <div class="col-md-4">
            <div class="bg-light rounded p-4 mb-4">
                <h5>
                    Availability
                </h5>

                @if($specialist->specialistProfile?->is_available)
                <span class="badge bg-success">
                    Available
                </span>
                @else
                <span class="badge bg-secondary">
                    Not Available
                </span>
                @endif
            </div>

            <div class="bg-light rounded p-4">
                <h5>
                    Current Projects
                </h5>

                @php
                $currentProjects = $specialist->projects->where('status', 'in_progress');
                @endphp

                @if($currentProjects->count())
                <h3> {{ $currentProjects->count() }} </h3>

                <ul class="mb-0">
                    @foreach($currentProjects as $project)
                    <li> {{ $project->name }} </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted mb-0"> No active projects.</p>
                @endif

            </div>
        </div>


        {{-- Projects --}}

        <div class="col-12">
            <div class="bg-light rounded p-4">
                <h5 class="mb-3">
                    Project History
                </h5>

                @forelse($specialist->projects as $project)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <strong>
                            {{ $project->name }}
                        </strong>

                        <div class="small text-muted">
                            {{ ucfirst(str_replace(
                                    '_',
                                    ' ',
                                    $project->status
                                )) }}
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted mb-0">
                    No projects yet.
                </p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection