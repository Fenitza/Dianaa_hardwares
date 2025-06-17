@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section" style="background-image: url('{{ asset('images/banners/careers.jpg') }}'); background-size: cover; background-position: center; height: 300px;">
        <div class="container text-center py-5">
            <!-- <h1>Careers</h1>
            <p>Join our team and help shape the future!</p> -->
        </div>
    </section>

    <!-- Main Content Section -->
    <div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Open Positions</h2>
            <div class="job-listings">
                @forelse($jobs as $job)
                    <div class="job mb-4">
                        <h3>{{ $job->title }}</h3>
                        <p>{{ Str::limit($job->description, 200) }}</p>
                        <p><strong>Location:</strong> {{ $job->location ?? 'Not specified' }}</p>
                        <a href="{{ route('careers.show', $job->id) }}" class="btn btn-primary">Learn More</a>
                    </div>
                @empty
                    <p>No job openings currently available.</p>
                @endforelse
            </div>
        </div>
    </div>


        <div class="row mt-5" id="work-with-us">
    <div class="col-md-6 work-with-us-text">
        <h2>Why Work With Us?</h2>
        <p>Discover the benefits and perks of joining our team.</p>
        <ul>
            <li>Competitive salaries and comprehensive health benefits</li>
            <li>Flexible working hours and remote work options</li>
            <li>Inclusive and dynamic company culture</li>
        </ul>
    </div>
    <div class="col-md-6 work-with-us-image">
        <img src="{{ asset('images/banners/culture.jpg') }}" alt="Our Company Culture" class="img-fluid">
    </div>
</div>

        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <h2>Ready to start your journey?</h2>
                <p>Apply today and make a real impact tomorrow.</p>
                <a href="#" class="btn btn-success">Submit Your Application</a>
            </div>
        </div>
    </div>
@endsection
