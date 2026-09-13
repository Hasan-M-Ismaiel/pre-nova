@extends('layouts.app')

@section('title', 'Our Projects • novALight')

@section('meta_description', 'Explore selected digital projects, creative solutions, and digital experiences delivered by novALight.')

@section('content')


<div class="container py-5">

    <div class="text-center mb-3">
        <h1 class="mb-3">
            Our Work
        </h1>

        <p class="text-muted mx-auto" style="max-width: 700px;">
            A selection of digital experiences, creative solutions,
            and projects we've helped bring to life.
        </p>
    </div>
</div>



<!-- Projects -->
<section class="py-5">

    <div class="container py-4">

        @if($projects->count())

        <div class="row g-4">

            @foreach($projects as $project)

            <div class="col-md-6 col-lg-4">

                <article class="h-100">

                    {{-- Project Image --}}
                    <a
                        href="{{ route('projects.show', $project->slug) }}"
                        class="text-decoration-none">

                        @if($project->media->count())

                        @php
                        $thumbnail = $project->media->first();
                        @endphp

                        <div
                            class="overflow-hidden rounded mb-4">

                            <img
                                src="{{ asset('storage/' . $thumbnail->file) }}"
                                alt="{{ $thumbnail->caption ?? $project->name }}"
                                class="img-fluid w-100"
                                style="height: 280px; object-fit: cover;">

                        </div>

                        @else

                        <div
                            class="bg-light rounded mb-4 d-flex align-items-center justify-content-center"
                            style="height: 280px;">

                            <span class="text-muted">
                                No image available
                            </span>

                        </div>

                        @endif

                    </a>


                    {{-- Project Info --}}
                    <div>

                        @if($project->industry)

                        <span class="text-primary small fw-semibold">
                            {{ $project->industry }}
                        </span>

                        @endif

                        <h3 class="h4 mt-2 mb-2">

                            <a
                                href="{{ route('projects.show', $project->slug) }}"
                                class="text-dark text-decoration-none">

                                {{ $project->name }}

                            </a>

                        </h3>


                        @if($project->client_name)

                        <p class="text-muted small mb-3">
                            {{ $project->client_name }}
                        </p>

                        @endif


                        @if($project->description)

                        <p class="text-muted mb-4">

                            {{ \Illuminate\Support\Str::limit(
                                            $project->description,
                                            140
                                        ) }}

                        </p>

                        @endif


                        {{-- Services --}}
                        @if($project->services->count())

                        <div class="d-flex flex-wrap gap-2 mb-4">

                            @foreach($project->services->take(3) as $service)

                            <span class="badge bg-light text-dark border">
                                {{ $service->name }}
                            </span>

                            @endforeach

                        </div>

                        @endif


                        <a
                            href="{{ route('projects.show', $project->slug) }}"
                            class="text-primary text-decoration-none fw-semibold">

                            View Project
                            <i class="fa fa-arrow-right ms-1"></i>

                        </a>

                    </div>

                </article>

            </div>

            @endforeach

        </div>

        @else

        <div class="text-center py-5">

            <h3>
                Projects coming soon
            </h3>

            <p class="text-muted">
                We're currently preparing our project showcase.
            </p>

        </div>

        @endif

    </div>

</section>


<!-- CTA -->
<section class="py-5 bg-dark text-white">

    <div class="container py-5 text-center">

        <h2 class="mb-3">
            Have a project in mind?
        </h2>

        <p class="text-white-50 mb-4">
            Let's create something meaningful together.
        </p>

        <a
            href="/#contact"
            class="btn btn-primary px-4 py-3">

            Start a Conversation

        </a>

    </div>

</section>

@endsection