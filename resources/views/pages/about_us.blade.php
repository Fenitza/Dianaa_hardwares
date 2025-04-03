@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section-about" style="background-image: url('{{ asset('images/banners/about_us.png') }}'); background-size: cover; background-position: center; height: 300px;">
        <div class="container text-center py-5">
            <!-- Optional text or elements can be added here if needed -->
        </div>
    </section>

    <!-- Main Content Section -->
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <h2>Our Story</h2>
                <div class="timeline">
                    <!-- Timeline items -->
                    @foreach([
                        ['year' => 'Year 2000', 'events' => [
                            'Founding of Dianaa Fasteners - Established as a key player in the fastener industry.',
                            'Partnership with Sundram Fasteners Limited - Became the largest stockist of TVS brand fasteners.'
                        ]],
                        ['year' => 'Year 2010', 'events' => [
                            'Expansion of Logistics Services - Enhanced logistics capabilities for better supply chain management.'
                        ]],
                        ['year' => 'Year 2015', 'events' => [
                            'Nationwide Coverage - Expanded operations to serve industries across the nation.'
                        ]],
                        ['year' => 'Year 2020', 'events' => [
                            'Innovations in Fastener Solutions - Introduced innovative solutions tailored to meet diverse industrial needs.'
                        ]],
                        ['year' => 'Year 2023', 'events' => [
                            'Celebration of 23 Years - Over two decades of excellence in fastener supply and logistics.'
                        ]]
                    ] as $item)
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-circle"></i>
                            </div>
                            <div class="timeline-content {{ $loop->iteration % 2 == 0 ? '' : 'right' }}">
                                <h4>{{ $item['year'] }}</h4>
                                @foreach ($item['events'] as $event)
                                    <p>{{ $event }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('images/banners/people.jpg') }}" alt="About Us" class="img-fluid" style="margin-top:30px; width: 100%;">
            </div>
        </div>
    </div>

    <!-- Quality Policy Section -->
    <div class="container py-5">
        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Quality Policy</h2>
                <p class="lead">Commitment to Zero Defects and Staff Training</p>
                <div class="row">
                    <!-- Quality cards -->
                    @foreach([
                        ['icon' => 'fas fa-shield-alt', 'title' => 'Preventing Customer Difficulties', 'text' => 'We prioritize our customers\' experiences by ensuring that quality is never compromised.'],
                        ['icon' => 'fas fa-cogs', 'title' => 'Implementing a Quality Policy', 'text' => 'Our policy is designed to achieve zero defects in all our processes, ensuring high standards.'],
                        ['icon' => 'fas fa-users', 'title' => 'Training for All Staff', 'text' => 'We commit to comprehensive training for all employees, enhancing our quality objectives.']
                    ] as $card)
                        <div class="col-md-4">
                            <div class="quality-card">
                                <div class="quality-icon">
                                    <i class="{{ $card['icon'] }}"></i>
                                </div>
                                <h3>{{ $card['title'] }}</h3>
                                <p>{{ $card['text'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Commitment to Customer Satisfaction Section -->
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <h2>Our Commitment to Customer Satisfaction</h2>
                <div class="row mt-5">
                    @php $zigzag = true; @endphp
                    @foreach([
                        ['title' => 'Serve Customers Effectively', 'text' => 'Our primary goal is to serve our customers effectively by leveraging our expertise to provide tailored solutions.'],
                        ['title' => 'Meet Customer Expectations', 'text' => 'We strive to understand and meet the expectations of our customers, ensuring their satisfaction with our services.'],
                        ['title' => 'Lower Inventory Holding Costs', 'text' => 'We focus on reducing inventory holding costs, which helps us to offer competitive pricing and better service.'],
                        ['title' => 'Address Customer Needs Promptly', 'text' => 'We are dedicated to addressing customer needs whenever and wherever necessary, ensuring timely support.'],
                        ['title' => 'Accurate Forecasting and Planning', 'text' => 'Through detailed forecasting and planning, we ensure that our inventory levels align with customer demand.'],
                        ['title' => 'Comprehensive Inventory Management', 'text' => 'Our inventory management practices are designed to optimize stock levels and minimize waste.']
                    ] as $feature)
                        <div class="col-md-6 col-lg-4{{ $zigzag ? ' offset-lg-2' : '' }}">
                            <div class="feature-box">
                                <h3>{{ $feature['title'] }}</h3>
                                <p>{{ $feature['text'] }}</p>
                            </div>
                        </div>
                        @php $zigzag = !$zigzag; @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
