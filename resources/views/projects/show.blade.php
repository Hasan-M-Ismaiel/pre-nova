@extends('layouts.app')

@section('title', $project->name . ' • novALight')

@section('meta_description', $project->description ?? 'Explore this project by novALight.')

@section('content')

<!-- Project Hero -->

<div class="container-fluid bg-light py-5">


<div class="container py-5">

    <div class="row align-items-center g-5">

        <div class="col-lg-7">

            <span class="text-primary fw-semibold">
                PROJECT
            </span>

            <h1 class="display-3 fw-bold mt-3 mb-4">
                {{ $project->name }}
            </h1>

            @if($project->client_name)

                <p class="fs-5 text-muted mb-2">
                    Client: {{ $project->client_name }}
                </p>

            @endif

            @if($project->industry)

                <p class="text-muted mb-0">
                    {{ $project->industry }}
                </p>

            @endif

        </div>


        <div class="col-lg-5">

            @if($project->media->count())

                @php
                    $featuredMedia = $project->media->first();
                @endphp

                <img
                    src="{{ asset('storage/' . $featuredMedia->file) }}"
                    alt="{{ $featuredMedia->caption ?? $project->name }}"
                    class="img-fluid rounded">

            @endif

        </div>

    </div>

</div>


</div>

<!-- Project Overview -->

@if($project->description)

<section class="py-5">


<div class="container py-4">

    <div class="row">

        <div class="col-lg-8">

            <span class="text-primary fw-semibold">
                OVERVIEW
            </span>

            <h2 class="mt-2 mb-4">
                About the Project
            </h2>

            <p class="text-muted fs-5">
                {!! nl2br(e($project->description)) !!}
            </p>

        </div>

    </div>

</div>


</section>

@endif

<!-- Challenge & Solution -->

@if($project->problem || $project->solution)

<section class="py-5 bg-light">


<div class="container py-4">

    <div class="row g-5">

        @if($project->problem)

        <div class="col-lg-6">

            <span class="text-primary fw-semibold">
                THE CHALLENGE
            </span>

            <h2 class="mt-2 mb-4">
                The Challenge
            </h2>

            <p class="text-muted">
                {!! nl2br(e($project->problem)) !!}
            </p>

        </div>

        @endif


        @if($project->solution)

        <div class="col-lg-6">

            <span class="text-primary fw-semibold">
                OUR APPROACH
            </span>

            <h2 class="mt-2 mb-4">
                Our Solution
            </h2>

            <p class="text-muted">
                {!! nl2br(e($project->solution)) !!}
            </p>

        </div>

        @endif

    </div>

</div>


</section>

@endif

<!-- Services -->

@if($project->services->count())

<section class="py-5">


<div class="container py-4">

    <span class="text-primary fw-semibold">
        WHAT WE DID
    </span>

    <h2 class="mt-2 mb-4">
        Services
    </h2>

    <div class="row g-3">

        @foreach($project->services as $service)

            <div class="col-md-4">

                <div class="border rounded p-4 h-100">

                    <h5 class="mb-0">
                        {{ $service->name }}
                    </h5>

                </div>

            </div>

        @endforeach

    </div>

</div>

</section>

@endif

<!-- Technologies -->

@if($project->technologies)

<section class="py-5 bg-light">

<div class="container py-4">

    <span class="text-primary fw-semibold">
        TECHNOLOGY
    </span>

    <h2 class="mt-2 mb-4">
        Technologies
    </h2>

    <div class="text-muted fs-5">

        {!! nl2br(e($project->technologies)) !!}

    </div>

</div>

</section>

@endif

<!-- Gallery -->

@if($project->media->count())

<section class="py-5">

<div class="container py-4">

    <span class="text-primary fw-semibold">
        VISUALS
    </span>

    <h2 class="mt-2 mb-5">
        Project Gallery
    </h2>

    <div class="row g-4">

        @foreach($project->media as $media)

            <div class="col-md-6">

                <div class="overflow-hidden rounded">

                    <img
                        src="{{ asset('storage/' . $media->file) }}"
                        alt="{{ $media->caption ?? $project->name }}"
                        class="img-fluid w-100"
                        style="display:block;">

                </div>

                @if($media->caption)

                    <p class="text-muted mt-2 mb-0">
                        {{ $media->caption }}
                    </p>

                @endif

            </div>

        @endforeach

    </div>

</div>

</section>

@endif

<!-- Results -->

@if($project->results)

<section class="py-5 bg-light">

<div class="container py-4">

    <div class="row">

        <div class="col-lg-8">

            <span class="text-primary fw-semibold">
                OUTCOME
            </span>

            <h2 class="mt-2 mb-4">
                Results
            </h2>

            <p class="text-muted fs-5">
                {!! nl2br(e($project->results)) !!}
            </p>

        </div>

    </div>

</div>
</section>

@endif

<!-- Team -->

@if($project->contributors->count())

<section class="py-5">

<div class="container py-4">

    <span class="text-primary fw-semibold">
        CONTRIBUTORS
    </span>

    <h2 class="mt-2 mb-5">
        The Team
    </h2>

    <div class="row g-4">

        @foreach($project->contributors as $contributor)

            <div class="col-md-6 col-lg-4">

                <div class="border rounded p-4 h-100">

                    <h5>
                        {{ $contributor->name }}
                    </h5>

                    @if($contributor->pivot->contribution)

                        <p class="text-muted mb-0">
                            {{ $contributor->pivot->contribution }}
                        </p>

                    @endif

                </div>

            </div>

        @endforeach

    </div>

</div>

</section>

@endif

@endsection
