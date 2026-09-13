@extends('layouts.app')

@section('title', 'Projects • novALight')

@section('content')

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                Projects
            </h2>

            <p class="text-muted mb-0">
                Manage novALight projects and portfolio.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a
                href="#"
                target="_blank"
                class="btn btn-outline-primary">
                View Public
            </a>

            <a
                href="{{ route('admin.projects.create') }}"
                class="btn btn-primary">
                Add Project
            </a>

        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-light rounded p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Client</th>
                        <th>Status</th>
                        <th>Visibility</th>
                        <th>Services</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($projects as $project)
                    <tr>
                        <td>
                            {{ $project->name }}
                            </strong>

                            <div class="small text-muted">
                                {{ $project->industry }}
                            </div>
                        </td>

                        <td>
                            {{ $project->client_name ?? '—' }}
                        </td>

                        <td>
                            @if($project->isOpen())
                            <span class="badge bg-primary">
                                Open
                            </span>
                            @elseif($project->isInProgress())
                            <span class="badge bg-info">
                                In Progress
                            </span>
                            @elseif($project->isOnHold())
                            <span class="badge bg-warning text-dark">
                                On Hold
                            </span>
                            @elseif($project->isClosed())
                            <span class="badge bg-success">
                                Closed
                            </span>
                            @elseif($project->isCanceled())
                            <span class="badge bg-danger">
                                Canceled
                            </span>
                            @endif
                        </td>

                        <td>
                            @if($project->is_public)
                            <span class="badge bg-success">
                                Public
                            </span>
                            @else
                            <span class="badge bg-secondary">
                                Private
                            </span>
                            @endif
                        </td>

                        <td>
                            @forelse($project->services as $service)
                            <span class="badge bg-light text-dark border"> {{ $service->name }} </span>
                            @empty

                            <span class="text-muted">
                                —
                            </span>

                            @endforelse
                        </td>

                        <td class="text-end">
                            <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-outline-secondary">
                                View
                            </a>

                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-outline-primary">
                                Edit
                            </a>

                            <form action="{{ route('admin.projects.destroy', $project) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm(
                                    'Are you sure you want to delete this project?'
                                );">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    Delete
                                </button>

                            </form>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td
                            colspan="6"
                            class="text-center text-muted py-4">
                            No projects found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection