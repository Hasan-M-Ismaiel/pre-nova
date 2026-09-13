@extends('layouts.app')

@section('title', 'Specialists • novALight')

@section('content')

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Specialists</h2>

            <p class="text-muted mb-0">
                Manage novALight specialists.
            </p>
        </div>

        <a href="{{ route('admin.specialists.create') }}"
            class="btn btn-primary">
            Add Specialist
        </a>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Availability</th>
                        <th>Current Projects</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($specialists as $specialist)
                    @php
                    $currentProjects = $specialist->projects
                    ->where('status', 'in_progress');
                    @endphp
                    <tr>
                        <td>
                            <strong>
                                {{ $specialist->name }}
                            </strong>

                            @if($specialist->specialistProfile?->headline)

                            <div class="small text-muted">
                                {{ $specialist->specialistProfile->headline }}
                            </div>
                            @endif
                        </td>

                        <td>
                            {{ $specialist->email }}
                        </td>

                        <td>
                            @forelse($specialist->roles as $role)

                            <span class="badge bg-secondary me-1">
                                {{ $role->name }}
                            </span>
                            @empty
                            <span class="text-muted">
                                No roles
                            </span>
                            @endforelse
                        </td>

                        <td>
                            @if($specialist->specialistProfile?->is_available)
                            <span class="badge bg-success">
                                Available
                            </span>
                            @else
                            <span class="badge bg-secondary">
                                Not Available
                            </span>
                            @endif
                        </td>

                        <td>
                            @if($currentProjects->count())
                            <span class="badge bg-primary">
                                {{ $currentProjects->count() }}
                            </span>
                            @else
                            <span class="text-muted">
                                None
                            </span>
                            @endif
                        </td>

                        <td class="text-end">
                            <a href="{{ route('admin.specialists.show', $specialist) }}"
                                class="btn btn-sm btn-outline-primary">
                                View
                            </a>

                            <a href="{{ route('admin.specialists.edit', $specialist) }}"
                                class="btn btn-sm btn-outline-secondary">
                                Edit
                            </a>
                        </td>
                    </tr>
                    @empty

                    <tr>
                        <td colspan="6"
                            class="text-center text-muted py-4">
                            No specialists found.
                        </td>
                    </tr>

                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection