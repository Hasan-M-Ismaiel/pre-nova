@extends('layouts.app')

@section('title', 'Create Project from Proposal • novALight')

@section('content')

<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Create Project</h2>

            <p class="text-muted mb-0">
                Create a project from an approved proposal.
            </p>
        </div>

        <a
            href="{{ route('admin.proposals.show', $proposal) }}"
            class="btn btn-outline-secondary"
        >
            Back to Proposal
        </a>

    </div>


    {{-- Errors --}}
    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Proposal Information --}}
    <div class="alert alert-success mb-4">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <strong>
                    Creating project from approved proposal
                </strong>

                <div class="mt-1">

                    {{ $proposal->title }}

                    @if($proposal->client_name)
                        — {{ $proposal->client_name }}
                    @endif

                </div>

            </div>

            <span class="badge bg-success">
                Approved
            </span>

        </div>

    </div>


    <div class="bg-light rounded p-4">

        <form
            method="POST"
            action="{{ route('admin.projects.store') }}"
        >

            @csrf

            {{-- Link Project to Proposal --}}
            <input
                type="hidden"
                name="proposal_id"
                value="{{ $proposal->id }}"
            >


            <div class="row">

                {{-- Project Name --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Project Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $proposal->title) }}"
                        required
                    >

                </div>


                {{-- Slug --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Slug
                    </label>

                    <input
                        type="text"
                        name="slug"
                        class="form-control"
                        value="{{ old('slug', \Illuminate\Support\Str::slug($proposal->title)) }}"
                        placeholder="my-project"
                    >

                </div>


                {{-- Client --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Client
                    </label>

                    <input
                        type="text"
                        name="client_name"
                        class="form-control"
                        value="{{ old('client_name', $proposal->client_name) }}"
                    >

                </div>


                {{-- Industry --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Industry
                    </label>

                    <input
                        type="text"
                        name="industry"
                        class="form-control"
                        value="{{ old('industry') }}"
                    >

                </div>


                {{-- Description --}}
                <div class="col-12 mb-3">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        class="form-control"
                    >{{ old('description', $proposal->description) }}</textarea>

                </div>


                {{-- Problem --}}
                <div class="col-12 mb-3">

                    <label class="form-label">
                        Problem
                    </label>

                    <textarea
                        name="problem"
                        rows="4"
                        class="form-control"
                    >{{ old('problem') }}</textarea>

                </div>


                {{-- Solution / Scope --}}
                <div class="col-12 mb-3">

                    <label class="form-label">
                        Solution / Scope
                    </label>

                    <textarea
                        name="solution"
                        rows="5"
                        class="form-control"
                    >{{ old('solution', $proposal->scope) }}</textarea>

                    <small class="text-muted">
                        The proposal scope has been copied here.
                        You can edit it before creating the project.
                    </small>

                </div>


                {{-- Technologies --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Technologies
                    </label>

                    <textarea
                        name="technologies"
                        rows="4"
                        class="form-control"
                    >{{ old('technologies') }}</textarea>

                    <small class="text-muted">
                        Example: Laravel, MySQL, Bootstrap
                    </small>

                </div>


                {{-- Results --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Results
                    </label>

                    <textarea
                        name="results"
                        rows="4"
                        class="form-control"
                    >{{ old('results') }}</textarea>

                </div>


                {{-- Status --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select"
                    >

                        <option
                            value="open"
                            {{ old('status', 'open') === 'open'
                                ? 'selected'
                                : '' }}
                        >
                            Open
                        </option>

                        <option
                            value="in_progress"
                            {{ old('status') === 'in_progress'
                                ? 'selected'
                                : '' }}
                        >
                            In Progress
                        </option>

                        <option
                            value="on_hold"
                            {{ old('status') === 'on_hold'
                                ? 'selected'
                                : '' }}
                        >
                            On Hold
                        </option>

                        <option
                            value="closed"
                            {{ old('status') === 'closed'
                                ? 'selected'
                                : '' }}
                        >
                            Closed
                        </option>

                        <option
                            value="canceled"
                            {{ old('status') === 'canceled'
                                ? 'selected'
                                : '' }}
                        >
                            Canceled
                        </option>

                    </select>

                </div>


                {{-- Services --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Services
                    </label>

                    <select
                        name="services[]"
                        class="form-select"
                        multiple
                        size="5"
                    >

                        @foreach($services as $service)

                            <option
                                value="{{ $service->id }}"
                                {{ in_array(
                                    $service->id,
                                    old('services', [])
                                ) ? 'selected' : '' }}
                            >
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
                                        class="form-select"
                                    >

                                        <option value="">
                                            Select Specialist
                                        </option>

                                        @foreach($specialists as $specialist)

                                            <option
                                                value="{{ $specialist->id }}"
                                            >
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
                                        class="form-select"
                                    >

                                        <option value="">
                                            Select Role
                                        </option>

                                        @foreach($roles as $role)

                                            <option
                                                value="{{ $role->id }}"
                                            >
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
                                        placeholder="What did this specialist contribute?"
                                    ></textarea>

                                </div>


                                {{-- Remove --}}
                                <div class="col-md-1 mb-3 d-flex align-items-end">

                                    <button
                                        type="button"
                                        class="btn btn-danger remove-contributor"
                                    >
                                        ×
                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>


                    <button
                        type="button"
                        id="add-contributor"
                        class="btn btn-outline-primary"
                    >
                        + Add Contributor
                    </button>

                </div>


                {{-- Public --}}
                <div class="col-12 mb-4 mt-4">

                    <div class="form-check">

                        <input
                            type="checkbox"
                            name="is_public"
                            value="1"
                            id="is_public"
                            class="form-check-input"
                            {{ old('is_public')
                                ? 'checked'
                                : '' }}
                        >

                        <label
                            for="is_public"
                            class="form-check-label"
                        >
                            Show this project on the public website
                        </label>

                    </div>

                </div>


                {{-- Submit --}}
                <div class="col-12">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="fa fa-folder-plus me-1"></i>
                        Create Project
                    </button>

                    <a
                        href="{{ route('admin.proposals.show', $proposal) }}"
                        class="btn btn-outline-secondary ms-2"
                    >
                        Cancel
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>


<script>

    let contributorIndex = 1;


    // Add Contributor
    document
        .getElementById('add-contributor')
        .addEventListener('click', function () {

            const wrapper =
                document.getElementById('contributors-wrapper');

            const row = `
                <div class="contributor-row border rounded p-3 mb-3">

                    <div class="row">

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Specialist
                            </label>

                            <select
                                name="contributors[${contributorIndex}][specialist_id]"
                                class="form-select"
                            >

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


                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Role
                            </label>

                            <select
                                name="contributors[${contributorIndex}][role_id]"
                                class="form-select"
                            >

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


                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Contribution
                            </label>

                            <textarea
                                name="contributors[${contributorIndex}][contribution]"
                                class="form-control"
                                rows="2"
                                placeholder="What did this specialist contribute?"
                            ></textarea>

                        </div>


                        <div class="col-md-1 mb-3 d-flex align-items-end">

                            <button
                                type="button"
                                class="btn btn-danger remove-contributor"
                            >
                                ×
                            </button>

                        </div>

                    </div>

                </div>
            `;

            wrapper.insertAdjacentHTML(
                'beforeend',
                row
            );

            contributorIndex++;

        });


    // Remove Contributor
    document.addEventListener('click', function (e) {

        if (
            e.target.classList.contains(
                'remove-contributor'
            )
        ) {

            e.target
                .closest('.contributor-row')
                .remove();

        }

    });

</script>

@endsection