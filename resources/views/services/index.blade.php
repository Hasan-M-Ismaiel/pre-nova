```blade
@extends('layouts.app')

@section('title', 'Services • novALight')

@section('content')

<div class="container py-5">

    {{-- Page Header --}}
    <div class="text-center mb-5">

        <h1>
            Our Services
        </h1>

        <p class="text-muted mx-auto" style="max-width: 700px;">
            From digital products to creative solutions,
            novALight brings together the right expertise
            for every project.
        </p>

    </div>

    {{-- Services --}}
    <div class="row g-4">

        @forelse($services as $service)

            <div class="col-md-6 col-lg-4">

                <article class="bg-light rounded overflow-hidden h-100 d-flex flex-column">

                    {{-- Image --}}
                    <a
                        href="{{ route('services.show', $service) }}"
                        class="text-decoration-none">

                        @if($service->image)

                            <div class="overflow-hidden">
                                <img
                                    src="{{ asset('storage/' . $service->image) }}"
                                    alt="{{ $service->name }}"
                                    class="img-fluid w-100"
                                    style="
                                        height: 240px;
                                        object-fit: cover;
                                    ">
                            </div>

                        @else

                            <div
                                class="bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center"
                                style="height: 240px;">

                                <span class="text-muted">
                                    No image available
                                </span>

                            </div>

                        @endif

                    </a>

                    {{-- Content --}}
                    <div class="p-4 d-flex flex-column flex-grow-1">

                        <h4 class="mb-3">
                            {{ $service->name }}
                        </h4>

                        @if($service->short_description)

                            <p class="text-muted mb-4">
                                {{ $service->short_description }}
                            </p>

                        @else

                            <p class="text-muted mb-4">
                                Discover how novALight can help
                                bring your ideas to life.
                            </p>

                        @endif

                        {{-- Button --}}
                        <div class="mt-auto">

                            <a
                                href="{{ route('services.show', $service) }}"
                                class="btn btn-primary">

                                Learn More

                                <i class="fas fa-arrow-right ms-2"></i>

                            </a>

                        </div>

                    </div>

                </article>

            </div>

        @empty

            <div class="col-12 text-center">

                <div class="bg-light rounded p-5">

                    <h4>
                        Our services are coming soon.
                    </h4>

                    <p class="text-muted mb-0">
                        We are currently preparing our service offerings.
                    </p>

                </div>

            </div>

        @endforelse

    </div>

</div>

@endsection
```
