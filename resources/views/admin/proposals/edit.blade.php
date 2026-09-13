@extends('layouts.app')

@section('title', 'Edit Proposal • novALight')

@section('content')

<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">Edit Proposal</h2>

            <p class="text-muted mb-0">
                Update proposal #{{ $proposal->id }}
            </p>
        </div>

        <a href="{{ route('admin.proposals.show', $proposal) }}"
           class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left me-1"></i>
            Back to Proposal
        </a>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Please fix the following errors:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('admin.proposals.update', $proposal) }}"
        method="POST">

        @csrf
        @method('PUT')


        <div class="row g-4">

            {{-- Main Content --}}
            <div class="col-lg-8">

                {{-- Basic Information --}}
                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Proposal Information</h5>
                    </div>

                    <div class="card-body">

                        {{-- Title --}}
                        <div class="mb-4">

                            <label for="title" class="form-label">
                                Proposal Title
                            </label>

                            <input
                                type="text"
                                name="title"
                                id="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $proposal->title) }}"
                                placeholder="e.g. Website Development Proposal"
                                required
                            >

                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Description --}}
                        <div class="mb-4">

                            <label for="description" class="form-label">
                                Description
                            </label>

                            <textarea
                                name="description"
                                id="description"
                                rows="6"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Describe the project and the client's requirements..."
                            >{{ old('description', $proposal->description) }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Scope --}}
                        <div class="mb-4">

                            <label for="scope" class="form-label">
                                Scope of Work
                            </label>

                            <textarea
                                name="scope"
                                id="scope"
                                rows="10"
                                class="form-control @error('scope') is-invalid @enderror"
                                placeholder="Define the services, deliverables, features, and responsibilities..."
                            >{{ old('scope', $proposal->scope) }}</textarea>

                            @error('scope')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Terms --}}
                        <div class="mb-0">

                            <label for="terms" class="form-label">
                                Terms & Conditions
                            </label>

                            <textarea
                                name="terms"
                                id="terms"
                                rows="8"
                                class="form-control @error('terms') is-invalid @enderror"
                                placeholder="Add payment terms, timeline, revisions, cancellation policy, etc..."
                            >{{ old('terms', $proposal->terms) }}</textarea>

                            @error('terms')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            {{-- Sidebar --}}
            <div class="col-lg-4">

                {{-- Client Information --}}
                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Client Information</h5>
                    </div>

                    <div class="card-body">

                        {{-- Client Name --}}
                        <div class="mb-3">

                            <label for="client_name" class="form-label">
                                Client Name
                            </label>

                            <input
                                type="text"
                                name="client_name"
                                id="client_name"
                                class="form-control @error('client_name') is-invalid @enderror"
                                value="{{ old('client_name', $proposal->client_name) }}"
                                required
                            >

                            @error('client_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Client Email --}}
                        <div class="mb-3">

                            <label for="client_email" class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="client_email"
                                id="client_email"
                                class="form-control @error('client_email') is-invalid @enderror"
                                value="{{ old('client_email', $proposal->client_email) }}"
                                placeholder="client@example.com"
                            >

                            @error('client_email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Client Phone --}}
                        <div class="mb-0">

                            <label for="client_phone" class="form-label">
                                Phone
                            </label>

                            <input
                                type="text"
                                name="client_phone"
                                id="client_phone"
                                class="form-control @error('client_phone') is-invalid @enderror"
                                value="{{ old('client_phone', $proposal->client_phone) }}"
                                placeholder="+971..."
                            >

                            @error('client_phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- Proposal Settings --}}
                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Proposal Settings</h5>
                    </div>

                    <div class="card-body">

                        {{-- Amount --}}
                        <div class="mb-3">

                            <label for="amount" class="form-label">
                                Amount
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    $
                                </span>

                                <input
                                    type="number"
                                    name="amount"
                                    id="amount"
                                    step="0.01"
                                    min="0"
                                    class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount', $proposal->amount) }}"
                                    placeholder="0.00"
                                >

                            </div>

                            @error('amount')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Status --}}
                        <div class="mb-0">

                            <label for="status" class="form-label">
                                Status
                            </label>

                            <select
                                name="status"
                                id="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required>

                                <option value="draft"
                                    {{ old('status', $proposal->status) === 'draft' ? 'selected' : '' }}>
                                    Draft
                                </option>

                                <option value="sent"
                                    {{ old('status', $proposal->status) === 'sent' ? 'selected' : '' }}>
                                    Sent
                                </option>

                                <option value="approved"
                                    {{ old('status', $proposal->status) === 'approved' ? 'selected' : '' }}>
                                    Approved
                                </option>

                                <option value="rejected"
                                    {{ old('status', $proposal->status) === 'rejected' ? 'selected' : '' }}>
                                    Rejected
                                </option>

                            </select>

                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- Actions --}}
                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <button
                            type="submit"
                            class="btn btn-primary w-100 mb-2">

                            <i class="fa fa-save me-1"></i>
                            Save Changes

                        </button>


                        <a
                            href="{{ route('admin.proposals.show', $proposal) }}"
                            class="btn btn-outline-secondary w-100">

                            Cancel

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection
