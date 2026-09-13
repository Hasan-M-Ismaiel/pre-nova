@extends('layouts.app')

@section('title', 'Add Project • novALight')

@section('content')

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Add Project</h2>

            <p class="text-muted mb-0">
                Create a new novALight project.
            </p>
        </div>

        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
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

    @if($proposal)
    <div class="alert alert-success mb-4">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <strong>
                    Creating project from approved proposal
                </strong>

                <div class="small mt-1">
                    {{ $proposal->title }}
                    —
                    {{ $proposal->client_name }}
                </div>
            </div>

            <a
                href="{{ route('admin.proposals.show', $proposal) }}"
                class="btn btn-sm btn-outline-success">
                View Proposal
            </a>

        </div>

    </div>
    @endif
    <div class="bg-light rounded p-4">
        <form
            method="POST"
            action="{{ route('admin.projects.store') }}"
            enctype="multipart/form-data">
            @csrf
            @if($proposal)
            <input
                type="hidden"
                name="proposal_id"
                value="{{ $proposal->id }}">
            @endif
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Project Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $proposal->title ?? '') }}"
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
                        value="{{ old('slug') }}"
                        placeholder="my-project">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Client
                    </label>

                    <input
                        type="text"
                        name="client_name"
                        class="form-control"
                        value="{{ old('client_name', $proposal->client_name ?? '') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Industry
                    </label>

                    <input
                        type="text"
                        name="industry"
                        class="form-control"
                        value="{{ old('industry') }}">
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">
                        Description
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        class="form-control">{{ old('description', $proposal->description ?? '') }}</textarea>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">
                        Problem
                    </label>

                    <textarea
                        name="problem"
                        rows="4"
                        class="form-control">{{ old('problem') }}</textarea>
                </div>


                <div class="col-12 mb-3">
                    <label class="form-label">
                        Solution
                    </label>

                    <textarea
                        name="solution"
                        rows="4"
                        class="form-control">{{ old('solution', $proposal->scope ?? '') }}</textarea>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Technologies
                    </label>

                    <textarea
                        name="technologies"
                        rows="4"
                        class="form-control">{{ old('technologies') }}</textarea>

                    <small class="text-muted">
                        Example: Laravel, MySQL, Bootstrap
                    </small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Results
                    </label>

                    <textarea
                        name="results"
                        rows="4"
                        class="form-control">{{ old('results') }}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select">

                        <option
                            value="open"
                            {{ old('status') === 'open'
                                ? 'selected'
                                : '' }}>
                            Open
                        </option>

                        <option
                            value="in_progress"
                            {{ old('status') === 'in_progress'
                                ? 'selected'
                                : '' }}>
                            In Progress
                        </option>

                        <option
                            value="on_hold"
                            {{ old('status') === 'on_hold'
                                ? 'selected'
                                : '' }}>
                            On Hold
                        </option>

                        <option
                            value="closed"
                            {{ old('status') === 'closed'
                                ? 'selected'
                                : '' }}>
                            Closed
                        </option>

                        <option
                            value="canceled"
                            {{ old('status') === 'canceled'
                                ? 'selected'
                                : '' }}>
                            Canceled
                        </option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Services
                    </label>

                    <select
                        name="services[]"
                        class="form-select"
                        multiple
                        size="5">

                        @foreach($services as $service)
                        <option
                            value="{{ $service->id }}"
                            {{ in_array($service->id, old('services', [])) ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                        @endforeach
                    </select>

                    <small class="text-muted">
                        Hold Ctrl / Cmd to select multiple services.
                    </small>
                </div>

                {{-- Contributors --}}
                <div class="col-12">

                    <hr class="my-4">

                    <h6 class="mb-3">
                        Contributors
                    </h6>

                    <div id="contributors-wrapper">

                        <div class="contributor-row border rounded p-3 mb-3">

                            <div class="row">

                                {{-- Specialist --}}
                                <div class="col-md-4 mb-3">

                                    <label class="form-label">
                                        Specialist
                                    </label>

                                    <select
                                        name="contributors[0][specialist_id]"
                                        class="form-select">

                                        <option value="">
                                            Select Specialist
                                        </option>

                                        @foreach($specialists as $specialist)

                                        <option
                                            value="{{ $specialist->id }}"
                                            {{ old('contributors.0.specialist_id') == $specialist->id ? 'selected' : '' }}>

                                            {{ $specialist->name }}

                                        </option>

                                        @endforeach

                                    </select>

                                </div>


                                {{-- Role --}}
                                <div class="col-md-3 mb-3">

                                    <label class="form-label">
                                        Role
                                    </label>

                                    <select
                                        name="contributors[0][role_id]"
                                        class="form-select">

                                        <option value="">
                                            Select Role
                                        </option>

                                        @foreach($roles as $role)

                                        <option
                                            value="{{ $role->id }}"
                                            {{ old('contributors.0.role_id') == $role->id ? 'selected' : '' }}>

                                            {{ $role->name }}

                                        </option>

                                        @endforeach

                                    </select>

                                </div>


                                {{-- Contribution --}}
                                <div class="col-md-4 mb-3">

                                    <label class="form-label">
                                        Contribution
                                    </label>

                                    <textarea
                                        name="contributors[0][contribution]"
                                        class="form-control"
                                        rows="2"
                                        placeholder="What did this specialist contribute?">{{ old('contributors.0.contribution') }}</textarea>

                                </div>


                                {{-- Remove --}}
                                <div class="col-md-1 mb-3 d-flex align-items-end">

                                    <button
                                        type="button"
                                        class="btn btn-danger remove-contributor">

                                        ×

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>


                    <button
                        type="button"
                        id="add-contributor"
                        class="btn btn-outline-primary">

                        + Add Contributor

                    </button>

                </div>

                {{-- Project Media --}}
                <div class="col-12">

                    <hr class="my-4">

                    <h6 class="mb-3">
                        Project Media
                    </h6>

                    <div class="border rounded p-4">

                        <p class="text-muted mb-3">
                            Upload images that will be used in the project gallery.
                        </p>

                        <input
                            type="file"
                            name="media[]"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp,.gif"
                            multiple>

                        <small class="text-muted">
                            You can select multiple images. JPG, PNG, WEBP or GIF. Maximum 5MB per image.
                        </small>

                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="form-check">
                        <input
                            type="checkbox"
                            name="is_public"
                            value="1"
                            id="is_public"
                            class="form-check-input"
                            {{ old('is_public')
                                ? 'checked'
                                : '' }}>

                        <label for="is_public" class="form-check-label">
                            Show this project on the public website
                        </label>
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        Create Project
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    let contributorIndex = 1;


    // Add Contributor
    document.getElementById('add-contributor').addEventListener('click', function() {

        const wrapper = document.getElementById('contributors-wrapper');

        const row = `
            <div class="contributor-row border rounded p-3 mb-3">

                <div class="row">

                    {{-- Specialist --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Specialist
                        </label>

                        <select
                            name="contributors[${contributorIndex}][specialist_id]"
                            class="form-select">

                            <option value="">
                                Select Specialist
                            </option>

                            @foreach($specialists as $specialist)

                                <option value="{{ $specialist->id }}">
                                    {{ $specialist->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Role --}}
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Role
                        </label>

                        <select
                            name="contributors[${contributorIndex}][role_id]"
                            class="form-select">

                            <option value="">
                                Select Role
                            </option>

                            @foreach($roles as $role)

                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Contribution --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Contribution
                        </label>

                        <textarea
                            name="contributors[${contributorIndex}][contribution]"
                            class="form-control"
                            rows="2"
                            placeholder="What did this specialist contribute?"></textarea>

                    </div>


                    {{-- Remove --}}
                    <div class="col-md-1 mb-3 d-flex align-items-end">

                        <button
                            type="button"
                            class="btn btn-danger remove-contributor">

                            ×

                        </button>

                    </div>

                </div>

            </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', row);

        contributorIndex++;

    });


    // Remove Contributor
    document.addEventListener('click', function(e) {

        if (e.target.classList.contains('remove-contributor')) {

            e.target.closest('.contributor-row').remove();

        }

    });
</script>

@endsection