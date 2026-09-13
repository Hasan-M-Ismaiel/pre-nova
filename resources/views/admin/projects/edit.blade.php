@extends('layouts.app')

@section('title', 'Edit ' . $project->name . ' • novALight')

@section('content')

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                Edit Project
            </h2>

            <p class="text-muted mb-0">
                {{ $project->name }}
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-outline-secondary"> View Project </a>

            <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary"> Back </a>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-light rounded p-4">
        <form method="POST" action="{{ route('admin.projects.update', $project) }}">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Name --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Project Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old(
                            'name',
                            $project->name
                        ) }}"
                        required>
                </div>

                {{-- Slug --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Slug
                    </label>

                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $project->slug) }}">
                </div>

                {{-- Client --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Client
                    </label>

                    <input type="text" name="client_name" class="form-control" value="{{ old('client_name', $project->client_name) }}">
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
                        value="{{ old(
                            'industry',
                            $project->industry
                        ) }}">
                </div>


                {{-- Description --}}
                <div class="col-12 mb-3">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        class="form-control">{{ old('description', $project->description) }}</textarea>
                </div>

                {{-- Problem --}}
                <div class="col-12 mb-3">
                    <label class="form-label">
                        Problem
                    </label>

                    <textarea
                        name="problem"
                        rows="4"
                        class="form-control">{{ old('problem', $project->problem) }}</textarea>
                </div>

                {{-- Solution --}}
                <div class="col-12 mb-3">
                    <label class="form-label">
                        Solution
                    </label>

                    <textarea
                        name="solution"
                        rows="4"
                        class="form-control">{{ old('solution', $project->solution) }}</textarea>
                </div>

                {{-- Technologies --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Technologies
                    </label>

                    <textarea
                        name="technologies"
                        rows="4"
                        class="form-control">{{ old('technologies',$project->technologies) }}</textarea>
                </div>


                {{-- Results --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Results
                    </label>

                    <textarea
                        name="results"
                        rows="4"
                        class="form-control">{{ old('results', $project->results) }}</textarea>
                </div>

                {{-- Status --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Status
                    </label>

                    <select name="status" class="form-select">
                        <option value="open" @selected(old('status', $project->status) === 'open')>
                            Open
                        </option>

                        <option value="in_progress" @selected(old('status', $project->status) === 'in_progress')>
                            in_progress
                        </option>

                        <option value="on_hold" @selected(old('status', $project->status) === 'on_hold')>
                            On Hold
                        </option>

                        <option value="closed" @selected(old('status', $project->status) === 'closed')>
                            Closed
                        </option>

                        <option value="canceled" @selected(old('status', $project->status) === 'canceled')>
                            Canceled
                        </option>

                    </select>
                </div>

                {{-- Services --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Services
                    </label>

                    @php
                    $selectedServices = old(
                    'services',
                    $project->services
                    ->pluck('id')
                    ->toArray()
                    );
                    @endphp

                    <select
                        name="services[]"
                        class="form-select"
                        multiple
                        size="5">

                        @foreach($services as $service)
                        <option value="{{ $service->id }}" @selected(in_array($service->id, $selectedServices))>
                            {{ $service->name }}
                        </option>
                        @endforeach

                    </select>

                    <small class="text-muted">
                        Hold Ctrl / Cmd to select multiple.
                    </small>

                </div>


                {{-- Contributors --}}
                <hr class="my-4">
                <h6 class="mb-3">Contributors</h6>

                <div id="contributors-wrapper">

                    @forelse($project->contributors as $index => $contributor)

                    <div class="contributor-row border rounded p-3 mb-3">

                        <div class="row">

                            {{-- Specialist --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Specialist</label>

                                <select name="contributors[{{ $index }}][specialist_id]"
                                    class="form-select">

                                    <option value="">Select Specialist</option>

                                    @foreach($specialists as $specialist)
                                    <option value="{{ $specialist->id }}"
                                        {{ $contributor->id == $specialist->id ? 'selected' : '' }}>
                                        {{ $specialist->name }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>

                            {{-- Role --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Role</label>

                                <select name="contributors[{{ $index }}][role_id]"
                                    class="form-select">

                                    <option value="">Select Role</option>

                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ $contributor->pivot->role_id == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>

                            {{-- Contribution --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Contribution</label>

                                <textarea
                                    name="contributors[{{ $index }}][contribution]"
                                    class="form-control"
                                    rows="2"
                                    placeholder="What did this specialist contribute?">{{ $contributor->pivot->contribution }}</textarea>
                            </div>

                            {{-- Remove --}}
                            <div class="col-md-1 mb-3 d-flex align-items-end">

                                <button type="button"
                                    class="btn btn-danger remove-contributor">
                                    ×
                                </button>

                            </div>

                        </div>

                    </div>

                    @empty

                    <div class="contributor-row border rounded p-3 mb-3">

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Specialist</label>

                                <select name="contributors[0][specialist_id]"
                                    class="form-select">

                                    <option value="">Select Specialist</option>

                                    @foreach($specialists as $specialist)
                                    <option value="{{ $specialist->id }}">
                                        {{ $specialist->name }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Role</label>

                                <select name="contributors[0][role_id]"
                                    class="form-select">

                                    <option value="">Select Role</option>

                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}">
                                        {{ $role->name }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Contribution</label>

                                <textarea
                                    name="contributors[0][contribution]"
                                    class="form-control"
                                    rows="2"
                                    placeholder="What did this specialist contribute?"></textarea>
                            </div>

                            <div class="col-md-1 mb-3 d-flex align-items-end">

                                <button type="button"
                                    class="btn btn-danger remove-contributor">
                                    ×
                                </button>

                            </div>

                        </div>

                    </div>

                    @endforelse

                </div>

                <button type="button"
                    id="add-contributor"
                    class="btn btn-outline-primary">
                    + Add Contributor
                </button>

                {{-- Public --}}
                <div class="col-12 mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="is_public" value="1" id="is_public" class="form-check-input"
                            @checked(old( 'is_public' , $project->is_public))>

                        <label
                            for="is_public"
                            class="form-check-label">
                            Show this project on the public website
                        </label>

                    </div>
                </div>

                {{-- Buttons --}}
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        Save Changes
                    </button>

                    <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Project Media --}}
    <div class="col-12">
        <hr class="my-4">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h6 class="mb-1">
                    Project Media
                </h6>

                <small class="text-muted">
                    Manage images that will appear in the project gallery.
                </small>
            </div>

            <span class="badge bg-secondary">
                {{ $project->media->count() }} images
            </span>

        </div>

    </div>
    {{-- Upload New Media --}}
    <div class="border rounded p-4 mb-4">

        <h6 class="mb-3">
            Upload New Image
        </h6>

        <form
            method="POST"
            action="{{ route('admin.projects.media.store', $project) }}"
            enctype="multipart/form-data">

            @csrf

            <div class="row align-items-end">

                <div class="col-md-5 mb-3 mb-md-0">

                    <label class="form-label">
                        Image
                    </label>

                    <input
                        type="file"
                        name="file"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp,.gif"
                        required>

                    <small class="text-muted">
                        JPG, JPEG, PNG, WEBP or GIF. Maximum 5MB.
                    </small>

                </div>


                <div class="col-md-5 mb-3 mb-md-0">

                    <label class="form-label">
                        Caption
                    </label>

                    <input
                        type="text"
                        name="caption"
                        class="form-control"
                        maxlength="255"
                        placeholder="e.g. Homepage design">

                </div>


                <div class="col-md-2">

                    <button
                        type="submit"
                        class="btn btn-primary w-100">

                        Upload

                    </button>

                </div>

            </div>

        </form>

    </div>

    {{-- Existing Media --}}
    @if($project->media->count())

    <div class="row">

        @foreach($project->media as $media)

        <div class="col-md-6 col-lg-4 mb-4">

            <div class="card h-100">

                {{-- Image --}}
                <img
                    src="{{ asset('storage/' . $media->file) }}"
                    alt="{{ $media->caption ?? $project->name }}"
                    class="card-img-top"
                    style="height: 220px; object-fit: cover;">


                <div class="card-body">

                    {{-- Edit Media --}}
                    <form
                        method="POST"
                        action="{{ route('admin.projects.media.update', [$project, $media]) }}">

                        @csrf
                        @method('PUT')


                        {{-- Caption --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Caption
                            </label>

                            <input
                                type="text"
                                name="caption"
                                class="form-control"
                                value="{{ $media->caption }}"
                                maxlength="255">

                        </div>


                        {{-- Sort Order --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Sort Order
                            </label>

                            <input
                                type="number"
                                name="sort_order"
                                class="form-control"
                                value="{{ $media->sort_order }}"
                                min="0">

                        </div>


                        <button
                            type="submit"
                            class="btn btn-sm btn-outline-primary">

                            Save Changes

                        </button>

                    </form>


                    {{-- Delete --}}
                    <form
                        method="POST"
                        action="{{ route('admin.projects.media.destroy', [$project, $media]) }}"
                        class="mt-2"
                        onsubmit="return confirm('Are you sure you want to delete this image?');">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-sm btn-outline-danger">

                            Delete

                        </button>

                    </form>

                </div>

            </div>

        </div>

        @endforeach

    </div>

    @else
    <div class="border rounded p-4 text-center text-muted">
        No media uploaded yet.
    </div>
    @endif
</div>

<!-- for adding contributors -->
<script>
    let contributorIndex = {
        {
            $project - > contributors - > count()
        }
    };

    document.getElementById('add-contributor').addEventListener('click', function() {

        const wrapper = document.getElementById('contributors-wrapper');

        const row = `
            <div class="contributor-row border rounded p-3 mb-3">
    
                <div class="row">
    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Specialist</label>
    
                        <select name="contributors[${contributorIndex}][specialist_id]"
                                class="form-select">
    
                            <option value="">Select Specialist</option>
    
                            @foreach($specialists as $specialist)
                                <option value="{{ $specialist->id }}">
                                    {{ $specialist->name }}
                                </option>
                            @endforeach
    
                        </select>
                    </div>
    
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Role</label>
    
                        <select name="contributors[${contributorIndex}][role_id]"
                                class="form-select">
    
                            <option value="">Select Role</option>
    
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
    
                        </select>
                    </div>
    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Contribution</label>
    
                        <textarea
                            name="contributors[${contributorIndex}][contribution]"
                            class="form-control"
                            rows="2"
                            placeholder="What did this specialist contribute?"></textarea>
                    </div>
    
                    <div class="col-md-1 mb-3 d-flex align-items-end">
    
                        <button type="button"
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


    document.addEventListener('click', function(e) {

        if (e.target.classList.contains('remove-contributor')) {

            e.target.closest('.contributor-row').remove();

        }

    });
</script>
@endsection