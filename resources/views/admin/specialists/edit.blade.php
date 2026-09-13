@extends('layouts.app')

@section('title', 'Edit Specialist • novALight')

@section('content')

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Edit Specialist</h2>

            <p class="text-muted mb-0">
                Update {{ $specialist->name }}'s information.
            </p>
        </div>

        <a href="{{ route('admin.specialists.show', $specialist) }}"
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
            action="{{ route('admin.specialists.update', $specialist) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $specialist->name) }}"
                        required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $specialist->email) }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        New Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control">

                    <small class="text-muted">
                        Leave empty to keep the current password.
                    </small>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Confirm New Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control">
                </div>


                <div class="col-12 mb-3">
                    <label class="form-label">
                        Headline
                    </label>

                    <input
                        type="text"
                        name="headline"
                        class="form-control"
                        value="{{ old(
                            'headline',
                            $specialist->specialistProfile?->headline
                        ) }}">
                </div>


                <!-- Bio -->
                <div class="col-12 mb-3">
                    <label class="form-label">
                        Bio
                    </label>

                    <textarea
                        name="bio"
                        rows="5"
                        class="form-control">{{ old('bio', $specialist->specialistProfile?->bio) }}</textarea>
                </div>

                <!-- Profile image -->
                <div class="col-12 mb-4">

                    <label class="form-label">
                        Profile Image
                    </label>

                    @if($specialist->specialistProfile?->profile_image)

                    <div class="mb-3">

                        <img
                            src="{{ asset('storage/' . $specialist->specialistProfile->profile_image) }}"
                            alt="{{ $specialist->name }}"
                            class="rounded"
                            style="width: 140px; height: 140px; object-fit: cover;">

                    </div>

                    @endif

                    <input
                        type="file"
                        name="profile_image"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp">

                    <small class="text-muted">
                        Leave empty to keep the current image.
                        JPG, PNG or WEBP. Maximum 5MB.
                    </small>

                </div>

                <!-- Roles -->
                <div class="col-12 mb-3">
                    <label class="form-label d-block">
                        Roles
                    </label>

                    @php
                    $selectedRoles = old('roles', $specialist->roles->pluck('id')->toArray());
                    @endphp

                    @foreach($roles as $role)
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="roles[]"
                            value="{{ $role->id }}"
                            id="role_{{ $role->id }}"
                            {{ in_array($role->id, $selectedRoles) ? 'checked' : '' }}>

                        <label
                            class="form-check-label"
                            for="role_{{ $role->id }}">
                            {{ $role->name }}
                        </label>
                    </div>
                    @endforeach
                </div>

                <div class="col-12 mb-4">
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="is_available"
                            value="1"
                            id="is_available"
                            {{ old('is_available', $specialist->specialistProfile?->is_available) ? 'checked' : '' }}>

                        <label class="form-check-label" for="is_available">
                            Specialist is currently available for work
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
                            {{ old('show_on_website', $specialist->specialistProfile?->show_on_website) ? 'checked' : '' }}>

                        <label
                            class="form-check-label"
                            for="show_on_website">
                            Show this specialist on the public website
                        </label>

                    </div>

                </div>

                <!-- Save button -->
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