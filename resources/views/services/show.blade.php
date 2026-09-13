@extends('layouts.app')

@section('title', $service->name . ' • novALight')

@section(
    'meta_description',
    $service->short_description
        ?? 'Learn more about novALight services.'
)

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="bg-light rounded overflow-hidden">

                {{-- Service Image --}}
                @if($service->image)

                    <div class="overflow-hidden">
                        <img
                            src="{{ asset('storage/' . $service->image) }}"
                            alt="{{ $service->name }}"
                            class="img-fluid w-100"
                            style="
                                height: 380px;
                                object-fit: cover;
                            ">
                    </div>

                @else

                    <div
                        class="bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="height: 300px;">

                        <span class="text-muted">
                            No image available
                        </span>

                    </div>

                @endif

                {{-- Service Content --}}
                <div class="p-5">

                    <h1 class="mb-3">
                        {{ $service->name }}
                    </h1>

                    @if($service->short_description)

                        <p class="lead text-muted">
                            {{ $service->short_description }}
                        </p>

                    @endif

                    @if($service->description)

                        <hr class="my-4">

                        <div>
                            {!! nl2br(e($service->description)) !!}
                        </div>

                    @endif

                    {{-- CTA --}}
                    <div class="mt-5">

                        <a
                            href="{{ url('/#contact') }}"
                            class="btn btn-primary">

                            Start a Conversation

                            <i class="fas fa-arrow-right ms-2"></i>

                        </a>

                        <a
                            href="{{ route('services.index') }}"
                            class="btn btn-outline-secondary ms-2">

                            All Services

                        </a>

                    </div>

                </div>

            </div>

        </div>
    </div>

</div>

@endsection