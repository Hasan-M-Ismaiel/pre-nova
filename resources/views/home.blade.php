@extends('layouts.app')

@section('content')

<!-- Start Hero Area -->
@include('includes.hero-section')
<!-- End Hero Area -->

<!-- Start about-section -->
@include('includes.about-section')
<!-- End about-section -->

<!-- Start feature-section -->
@include('includes.feature-section')
<!-- End feature-section -->

<!-- Start projects-section -->
<!-- include('includes.projects-section') -->
<!-- End projects-section -->

<!-- Start services-section -->
@include('includes.services-section')
<!-- End services-section -->

<!-- Start team-section -->
<!-- include('includes.team-section') -->
<!-- End team-section -->

<!-- Start testimonial-section -->
<!-- include('includes.testimonials-section') -->
<!-- End testimonial-section -->

<!-- Start contact-section -->
@include('includes.contact-section')
<!-- End contact-section -->

@endsection