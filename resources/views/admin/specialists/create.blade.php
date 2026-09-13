@extends('layouts.app')

@section('title', 'Add Specialist • novALight')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Add Specialist</h2>
            <p class="text-muted mb-0">
                Create a specialist account.
            </p>
        </div>

        <a href="{{ route('admin.specialists.index') }}"
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
            action="{{ route('admin.specialists.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Name
                    </label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
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
                        value="{{ old('email') }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        required>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">
                        Headline
                    </label>

                    <input
                        type="text"
                        name="headline"
                        class="form-control"
                        placeholder="e.g. UI/UX Designer & Product Designer"
                        value="{{ old('headline') }}">

                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">
                        Bio
                    </label>

                    <textarea
                        name="bio"
                        rows="5"
                        class="form-control">{{ old('bio') }}</textarea>
                </div>

                <!-- profile image -->
                <div class="col-12 mb-4">

                    <label class="form-label">
                        Profile Image
                    </label>

                    <input
                        type="file"
                        name="profile_image"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp">

                    <small class="text-muted">
                        JPG, PNG or WEBP. Maximum 5MB.
                    </small>

                </div>

                <div class="col-12 mb-3">
                    <label class="form-label d-block">
                        Roles
                    </label>

                    @foreach($roles as $role)
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="roles[]"
                            value="{{ $role->id }}"
                            id="role_{{ $role->id }}"
                            {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>

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
                            {{ old('is_available') ? 'checked' : '' }}>

                        <label
                            class="form-check-label"
                            for="is_available">
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
                            {{ old('show_on_website', true) ? 'checked' : '' }}>

                        <label
                            class="form-check-label"
                            for="show_on_website">
                            Show this specialist on the public website
                        </label>
                    </div>
                </div>

                <div class="col-12">
                    <button
                        type="submit"
                        class="btn btn-primary">
                        Create Specialist
                    </button>

                </div>
            </div>
        </form>
    </div>
</div>

@endsection