@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section-about" style="background-image: url('{{ asset('images/banners/about_us.png') }}'); background-size: cover; background-position: center; height: 300px;">>
        <div class="container text-center py-5">
            <!-- <h1>About Us</h1>
            <p>Learn more about our company and values.</p> -->
        </div>
    </section>

    <!-- About Content Section -->
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <h2>Our Story</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et elementum nulla, sit amet accumsan justo. Donec non est at libero vulputate rutrum.</p>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('images/banners/people.jpg') }}" alt="About Us" class="img-fluid" style="height: 400px;">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <h3>Our Mission</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="col-md-4">
                <h3>Our Vision</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="col-md-4">
                <h3>Our Values</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
        </div>
    </div>
@endsection
