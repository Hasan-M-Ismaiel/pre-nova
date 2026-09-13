@extends('layouts.app')

@section('title', 'Our Specialists • novALight')

@section(
'meta_description',
'Meet the specialists behind novALight and explore their expertise and experience.'
)

@section('content')

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="mb-3">
            Our Specialists
        </h1>

        <p class="text-muted mx-auto" style="max-width: 700px;">
            novALight brings together independent specialists with
            focused expertise to build the right team for every project.
        </p>
    </div>

    <div class="row g-4">
        @forelse($specialists as $specialist)
        <article class="h-100">
            <div class="col-md-6 col-lg-4">
                {{-- Profile Image --}}
                <a
                    href="#"
                    class="text-decoration-none">

                    @if($specialist->specialistProfile?->profile_image)

                    <div
                        class="overflow-hidden rounded">

                        <img
                            src="{{ asset('storage/' . $specialist->specialistProfile->profile_image) }}"
                            alt="{{ $specialist->name }}"
                            class="img-fluid w-100"
                            style="height: 280px; object-fit: cover;">

                    </div>

                    @else

                    <div
                        class="bg-light rounded d-flex align-items-center justify-content-center"
                        style="height: 280px;">

                        <span class="text-muted">
                            No image available
                        </span>

                    </div>

                    @endif

                </a>
                <div class="bg-light rounded p-4 h-100">
                    <div class="mb-3">
                        <h4 class="mb-1">
                            {{ $specialist->name }}
                        </h4>

                        @if($specialist->specialistProfile?->headline)
                        <p class="text-muted mb-0">
                            {{ $specialist->specialistProfile->headline }}
                        </p>
                        @endif
                    </div>

                    <div class="mb-3">
                        @foreach($specialist->roles as $role)
                        <span class="badge bg-secondary me-1 mb-1">
                            {{ $role->name }}
                        </span>
                        @endforeach
                    </div>

                    @if($specialist->specialistProfile?->bio)
                    <p class="text-muted">
                        {{ \Illuminate\Support\Str::limit(
                                $specialist->specialistProfile->bio,
                                150
                            ) }}
                    </p>
                    @endif

                    <a href="{{ route('specialists.show', $specialist) }}"
                        class="btn btn-primary">
                        View Profile
                    </a>
                </div>
            </div>

        </article>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <p class="text-muted">
                    Our specialist profiles are coming soon.
                </p>
            </div>
        </div>
        @endforelse
    </div>
</div>

@endsection