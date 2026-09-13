@extends('layouts.app')

@section('title', 'Proposal • ' . $proposal->title)

@section('content')

<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <h2 class="mb-0">{{ $proposal->title }}</h2>

                @php
                $statusClasses = [
                'draft' => 'bg-secondary',
                'sent' => 'bg-info',
                'approved' => 'bg-success',
                'rejected' => 'bg-danger',
                ];
                @endphp

                <span class="badge {{ $statusClasses[$proposal->status] ?? 'bg-secondary' }}">
                    {{ ucfirst($proposal->status) }}
                </span>
                @if($proposal->sent_at)

                <div class="mb-3">

                    <small class="text-muted d-block">
                        <strong>
                            {{ $proposal->sent_at->format('M d, Y H:i') }}
                        </strong>
                    </small>

                </div>

                @endif
            </div>

            <p class="text-muted mb-0">
                Proposal #{{ $proposal->id }}
                · Created {{ $proposal->created_at->format('M d, Y') }}
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('admin.proposals.edit', $proposal) }}"
                class="btn btn-primary">
                <i class="fa fa-edit me-1"></i>
                Edit
            </a>

            @if($proposal->status === 'draft')

            <form
                action="{{ route('admin.proposals.send', $proposal) }}"
                method="POST"
                onsubmit="return confirm('Send this proposal to {{ $proposal->client_email }}?');">

                @csrf

                <button
                    type="submit"
                    class="btn btn-success">
                    <i class="fa fa-paper-plane me-1"></i>
                    Send Proposal
                </button>

            </form>

            @endif

            <form action="{{ route('admin.proposals.destroy', $proposal) }}"
                method="POST"
                onsubmit="return confirm('Are you sure you want to delete this proposal?');">

                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-outline-danger">
                    <i class="fa fa-trash me-1"></i>
                    Delete
                </button>

            </form>

        </div>

    </div>


    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($proposal->status === 'approved' && !$proposal->project_id)

    <a
        href="{{ route('admin.projects.create-from-proposal', $proposal) }}"
        class="btn btn-primary">
        <i class="fa fa-folder-plus me-1"></i>
        Create Project
    </a>

    @endif

    @if($proposal->project_id)

    <a
        href="{{ route('admin.projects.show', $proposal->project_id) }}"
        class="btn btn-outline-primary">
        <i class="fa fa-folder-open me-1"></i>
        View Project
    </a>

    @endif

    <div class="row g-4">

        {{-- Main Content --}}
        <div class="col-lg-8">

            {{-- Client --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Client Information</h5>
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <small class="text-muted d-block">
                                Client Name
                            </small>

                            <strong>
                                {{ $proposal->client_name }}
                            </strong>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block">
                                Email
                            </small>

                            @if($proposal->client_email)

                            <a href="mailto:{{ $proposal->client_email }}">
                                {{ $proposal->client_email }}
                            </a>

                            @else

                            <span class="text-muted">
                                Not provided
                            </span>

                            @endif
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block">
                                Phone
                            </small>

                            @if($proposal->client_phone)

                            <a href="tel:{{ $proposal->client_phone }}">
                                {{ $proposal->client_phone }}
                            </a>

                            @else

                            <span class="text-muted">
                                Not provided
                            </span>

                            @endif
                        </div>

                    </div>

                </div>

            </div>


            {{-- Description --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Description</h5>
                </div>

                <div class="card-body">

                    @if($proposal->description)

                    <div class="proposal-content">
                        {!! nl2br(e($proposal->description)) !!}
                    </div>

                    @else

                    <p class="text-muted mb-0">
                        No description provided.
                    </p>

                    @endif

                </div>

            </div>


            {{-- Scope --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Scope of Work</h5>
                </div>

                <div class="card-body">

                    @if($proposal->scope)

                    <div class="proposal-content">
                        {!! nl2br(e($proposal->scope)) !!}
                    </div>

                    @else

                    <p class="text-muted mb-0">
                        No scope of work provided.
                    </p>

                    @endif

                </div>

            </div>


            {{-- Terms --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Terms & Conditions</h5>
                </div>

                <div class="card-body">

                    @if($proposal->terms)

                    <div class="proposal-content">
                        {!! nl2br(e($proposal->terms)) !!}
                    </div>

                    @else

                    <p class="text-muted mb-0">
                        No terms provided.
                    </p>

                    @endif

                </div>

            </div>

        </div>


        {{-- Sidebar --}}
        <div class="col-lg-4">

            {{-- Amount --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Proposal Value</h5>
                </div>

                <div class="card-body">

                    @if($proposal->amount !== null)

                    <h2 class="mb-0">
                        ${{ number_format($proposal->amount, 2) }}
                    </h2>

                    @else

                    <span class="text-muted">
                        No amount specified
                    </span>

                    @endif

                </div>

            </div>


            {{-- Project --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Project</h5>
                </div>

                <div class="card-body">

                    @if($proposal->project)

                    <a href="{{ route('admin.projects.show', $proposal->project) }}"
                        class="text-decoration-none">

                        <strong>
                            {{ $proposal->project->name }}
                        </strong>

                    </a>

                    @else

                    <span class="text-muted">
                        Not linked to a project yet.
                    </span>

                    @endif

                </div>

            </div>


            {{-- Client Link --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Client Access</h5>
                </div>

                <div class="card-body">

                    <p class="text-muted small">
                        Share this proposal with the client using the
                        secure public link.
                    </p>

                    <div class="input-group">

                        <input
                            type="text"
                            class="form-control"
                            id="proposalLink"
                            value="{{ url('/proposals/' . $proposal->token) }}"
                            readonly>

                        <button
                            class="btn btn-outline-secondary"
                            type="button"
                            onclick="copyProposalLink()">
                            Copy
                        </button>

                    </div>

                </div>

            </div>


            {{-- Dates --}}
            <div class="card shadow-sm border-0">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Timeline</h5>
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <small class="text-muted d-block">
                            Created
                        </small>

                        <strong>
                            {{ $proposal->created_at->format('M d, Y H:i') }}
                        </strong>
                    </div>

                    @if($proposal->approved_at)

                    <div>
                        <small class="text-muted d-block">
                            Approved
                        </small>

                        <strong>
                            {{ $proposal->approved_at->format('M d, Y H:i') }}
                        </strong>
                    </div>

                    @endif

                </div>

            </div>

        </div>

    </div>


</div>


<script>
    function copyProposalLink() {

        const input = document.getElementById('proposalLink');

        navigator.clipboard.writeText(input.value)
            .then(() => {
                alert('Proposal link copied.');
            })
            .catch(() => {
                input.select();
                document.execCommand('copy');
                alert('Proposal link copied.');
            });
    }
</script>

@endsection