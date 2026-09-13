@extends('layouts.app')

@section('title', 'Admin Dashboard • novALight')

@section('content')

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                Admin Dashboard
            </h2>
            <p class="text-muted mb-0">
                Welcome back, {{ auth()->user()->name }}
            </p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger">
                Logout
            </button>
        </form>
    </div>


    <div class="row g-4">
        <div class="col-md-3">

            <div class="bg-light rounded p-4">

                <h5>Specialists</h5>

                <p class="text-muted">
                    Manage novALight specialists.
                </p>

                <a
                    href="{{ route('admin.specialists.index') }}"
                    class="btn btn-primary">
                    Manage Specialists
                </a>

            </div>

        </div>


        <div class="col-md-3">
            <div class="bg-light rounded p-4">
                <h5>Services</h5>

                <p class="text-muted">
                    Manage novALight services.
                </p>

                <a href="{{ route('admin.services.index') }}" class="btn btn-primary">
                    Manage Services
                </a>

            </div>

        </div>

        <div class="col-md-3">
            <div class="bg-light rounded p-4">
                <h5>Projects</h5>

                <p class="text-muted">Manage novALight projects.</p>

                <a href="{{ route('admin.projects.index') }}" class="btn btn-primary"> Manage Projects </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="bg-light rounded p-4">
                <h5>Proposals</h5>

                <p class="text-muted">Manage novALight Proposals.</p>

                <a href="{{ route('admin.proposals.index') }}" class="btn btn-primary"> Manage Proposals </a>
            </div>
        </div>
    </div>
</div>

@endsection