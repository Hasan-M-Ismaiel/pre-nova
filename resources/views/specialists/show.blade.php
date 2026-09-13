@extends('layouts.app')

@section('title', $specialist->name . ' • novALight')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            {{-- Profile Header --}}
            <div class="bg-light rounded p-5 mb-4">
                <div class="row align-items-center"> {{-- Profile Image --}}
                    <div class="col-md-3 text-center mb-4 mb-md-0">
                        @if($specialist->specialistProfile?->profile_image)
                        <img src="{{ asset('storage/' . $specialist->specialistProfile->profile_image) }}" alt="{{ $specialist->name }}" class="rounded-circle img-fluid" style=" width: 160px; height: 160px; object-fit: cover; ">
                        @else
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto" style=" width: 160px; height: 160px; font-size: 48px; ">
                            {{ strtoupper(substr($specialist->name, 0, 1)) }}
                        </div>
                        @endif
                    </div>
                    {{-- Name / Headline --}}
                    <div class="col-md-6 text-center text-md-start">
                        <h1 class="mb-2"> {{ $specialist->name }} </h1>
                        @if($specialist->specialistProfile?->headline)
                        <h5 class="text-muted mb-0">
                            {{ $specialist->specialistProfile->headline }}
                        </h5>
                        @endif
                    </div> {{-- Badge --}}
                    <div class="col-md-3 text-center text-md-end mt-4 mt-md-0">
                        <span class="badge bg-primary"> novALight Specialist </span>
                    </div>
                </div>
            </div>

            {{-- About --}}
            <div class="bg-light rounded p-4 mb-4">
                <h4 class="mb-3">
                    About
                </h4>
                @if($specialist->specialistProfile?->bio)
                <p class="mb-0">
                    {{ $specialist->specialistProfile->bio }}
                </p>
                @else
                <p class="text-muted mb-0">
                    Profile information coming soon.
                </p>
                @endif
            </div>

            {{-- Expertise --}}
            <div class="bg-light rounded p-4 mb-4">
                <h4 class="mb-3">
                    Expertise
                </h4>
                @foreach($specialist->roles as $role)
                <span class="badge bg-secondary me-2 mb-2">
                    {{ $role->name }}
                </span>
                @endforeach
            </div>

            {{-- Projects --}}
            <div class="bg-light rounded p-4">
                <h4 class="mb-4">
                    Selected Work
                </h4>

                @forelse($specialist->projects as $project)
                @if($project->status === 'closed')
                <div class="border-bottom pb-3 mb-3">
                    <h5>
                        {{ $project->name }}
                    </h5>
                    @if($project->description)
                    <p class="text-muted mb-0">
                        {{ $project->description }}
                    </p>
                    @endif
                </div>
                @endif
                @empty
                <p class="text-muted mb-0">
                    Selected work will be added soon.
                </p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection