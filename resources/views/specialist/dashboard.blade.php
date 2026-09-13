@extends('layouts.app')

@section('title', 'Specialist Dashboard • novALight')

@section('content')

<div class="container py-5">
    <h2>
        Specialist Dashboard
    </h2>

    <p class="text-muted">
        Welcome, {{ auth()->user()->name }}
    </p>

</div>

@endsection