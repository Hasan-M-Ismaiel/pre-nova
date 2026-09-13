@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="bg-light rounded p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h5 class="mb-0">
                Create Proposal
            </h5>

            <a href="{{ route('admin.proposals.index') }}"
               class="btn btn-outline-secondary">
                Back
            </a>

        </div>

        <form action="{{ route('admin.proposals.store') }}"
              method="POST">

            @csrf

            {{-- Proposal Information --}}

            <h6 class="mb-3">
                Proposal Information
            </h6>

            <div class="row">

                <div class="col-md-8 mb-3">

                    <label class="form-label">
                        Proposal Title
                    </label>

                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ old('title') }}"
                           placeholder="e.g. Corporate Website Development">

                    @error('title')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Amount
                    </label>

                    <input type="number"
                           step="0.01"
                           min="0"
                           name="amount"
                           class="form-control"
                           value="{{ old('amount') }}"
                           placeholder="0.00">

                    @error('amount')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>


            {{-- Client Information --}}

            <h6 class="mt-4 mb-3">
                Client Information
            </h6>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Client Name
                    </label>

                    <input type="text"
                           name="client_name"
                           class="form-control"
                           value="{{ old('client_name') }}">

                    @error('client_name')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        Client Email
                    </label>

                    <input type="email"
                           name="client_email"
                           class="form-control"
                           value="{{ old('client_email') }}">

                    @error('client_email')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        Client Phone
                    </label>

                    <input type="text"
                           name="client_phone"
                           class="form-control"
                           value="{{ old('client_phone') }}">

                    @error('client_phone')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>


            {{-- Description --}}

            <h6 class="mt-4 mb-3">
                Description
            </h6>

            <div class="mb-3">

                <textarea name="description"
                          rows="4"
                          class="form-control"
                          placeholder="Brief description of the project and client's needs...">{{ old('description') }}</textarea>

                @error('description')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- Scope --}}

            <h6 class="mt-4 mb-3">
                Scope of Work
            </h6>

            <div class="mb-3">

                <textarea name="scope"
                          rows="7"
                          class="form-control"
                          placeholder="Describe what novALight will deliver...">{{ old('scope') }}</textarea>

                @error('scope')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- Terms --}}

            <h6 class="mt-4 mb-3">
                Terms & Conditions
            </h6>

            <div class="mb-3">

                <textarea name="terms"
                          rows="7"
                          class="form-control"
                          placeholder="Payment terms, timeline, revisions, responsibilities, etc.">{{ old('terms') }}</textarea>

                @error('terms')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- Status --}}

            <h6 class="mt-4 mb-3">
                Proposal Status
            </h6>

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select name="status"
                            class="form-select">

                        <option value="draft"
                            {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>

                        <option value="sent"
                            {{ old('status') === 'sent' ? 'selected' : '' }}>
                            Sent
                        </option>

                        <option value="approved"
                            {{ old('status') === 'approved' ? 'selected' : '' }}>
                            Approved
                        </option>

                        <option value="rejected"
                            {{ old('status') === 'rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>

                    </select>

                    @error('status')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>


            {{-- Submit --}}

            <div class="mt-4">

                <button type="submit"
                        class="btn btn-primary">
                    Create Proposal
                </button>

                <a href="{{ route('admin.proposals.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection