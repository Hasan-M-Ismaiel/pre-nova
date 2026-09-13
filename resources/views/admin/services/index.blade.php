@extends('layouts.app')

@section('title', 'Services • novALight')

@section('content')

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">Services</h2>

            <p class="text-muted mb-0">
                Manage the services offered by novALight.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('services.index') }}" target="_blank" class="btn btn-outline-primary">
                View Public Services
            </a>

            <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                Add Service
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
                        <th>Service</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Website</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($services as $service)
                    <tr>
                        <td>
                            <strong>
                                {{ $service->name }}
                            </strong>

                            @if($service->short_description)
                            <div class="small text-muted">
                                {{ $service->short_description }}
                            </div>
                            @endif
                        </td>

                        <td>
                            <code>
                                {{ $service->slug }}
                            </code>
                        </td>

                        <td>
                            @if($service->is_active)
                            <span class="badge bg-success">
                                Active
                            </span>
                            @else
                            <span class="badge bg-secondary">
                                Inactive
                            </span>
                            @endif
                        </td>

                        <td>
                            @if($service->image)

                            <img
                                src="{{ asset('storage/' . $service->image) }}"
                                alt="{{ $service->name }}"
                                style="
                                        width: 70px;
                                        height: 50px;
                                        object-fit: cover;
                                    "
                                class="rounded">

                            @else

                            <span class="text-muted small">
                                No image
                            </span>

                            @endif
                        </td>

                        <td>
                            @if($service->show_on_website)
                            <span class="badge bg-primary">
                                Visible
                            </span>
                            @else
                            <span class="badge bg-secondary">
                                Hidden
                            </span>
                            @endif
                        </td>

                        <td class="text-end">
                            <a
                                href="{{ route(
                                    'admin.services.edit',
                                    $service
                                ) }}"
                                class="btn btn-sm btn-outline-primary">
                                Edit
                            </a>

                            <form action="{{ route('admin.services.destroy', $service) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this service?');">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-sm btn-outline-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty

                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            No services found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection