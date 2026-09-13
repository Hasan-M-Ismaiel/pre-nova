@extends('layouts.app')

@section('title', 'Edit Service • novALight')

@section('content')

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Edit Service</h2>

            <p class="text-muted mb-0">
                Update {{ $service->name }}.
            </p>
        </div>

        <a
            href="{{ route('admin.services.index') }}"
            class="btn btn-outline-secondary">
            Back
        </a>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-light rounded p-4">
        <form
            method="POST"
            action="{{ route('admin.services.update', $service) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Service Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $service->name) }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Slug
                    </label>

                    <input
                        type="text"
                        name="slug"
                        class="form-control"
                        value="{{ old('slug', $service->slug) }}">
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">
                        Short Description
                    </label>

                    <input
                        type="text"
                        name="short_description"
                        class="form-control"
                        value="{{ old('short_description', $service->short_description) }}">
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">
                        Description
                    </label>

                    <textarea
                        name="description"
                        rows="6"
                        class="form-control"> {{ old('description', $service->description) }}</textarea>
                </div>

                <!-- image -->
                <div class="col-12 mb-4">

                    <label class="form-label">
                        Service Image
                    </label>

                    @if($service->image)

                    <div class="mb-3">
                        <img
                            src="{{ asset('storage/' . $service->image) }}"
                            alt="{{ $service->name }}"
                            style="
                    width: 220px;
                    height: 140px;
                    object-fit: cover;
                "
                            class="rounded">
                    </div>

                    @endif

                    <input
                        type="file"
                        name="image"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp">

                    <small class="text-muted">
                        Leave empty to keep the current image.
                        JPG, PNG or WEBP. Maximum 5MB.
                    </small>

                </div>

                <div class="col-12 mb-3">
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="is_active"
                            value="1"
                            id="is_active"
                            {{ old('is_active', $service->is_active) ? 'checked' : '' }}>

                        <label class="form-check-label" for="is_active">
                            Active service
                        </label>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="show_on_website"
                            value="1"
                            id="show_on_website"
                            {{ old('show_on_website', $service->show_on_website) ? 'checked' : '' }}>

                        <label class="form-check-label" for="show_on_website">
                            Show on public website
                        </label>
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection