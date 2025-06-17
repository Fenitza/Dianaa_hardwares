@extends('layouts.app')
<title>Services-Dianaa Fasteners</title>
@section('content')
    <!-- Hero Section -->
    <section class="hero-section-about" style="background-image: url('{{ asset('images/banners/services.png') }}'); background-size: cover; background-position: center; height: 300px;">
        <div class="container text-center py-5">
            <!-- Optional text or elements can be added here if needed -->
        </div>
    </section>

<!-- Our Products Section -->
<div class="container-fluid py-5" style="background: linear-gradient(to bottom right, #f5f8fd, #eaf4ff);">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Our Products</h2>
        <p class="text-muted">Precision-engineered fasteners for every industrial need</p>
    </div>

    <!-- Scroll Container -->
    <div class="position-relative overflow-hidden">
        <div id="productScroller" class="d-flex flex-nowrap" style="overflow-x: auto; scroll-behavior: smooth; scroll-snap-type: x mandatory;">
            @foreach([
                ['title' => 'High-Tensile Bolts & Nuts', 'descrip'=>'Conforming to IS, ASTM, BS, DIN & ISO standards', 'img' => 'images/Products/product_2.jpg'],
                ['title' => 'Stud Bolts', 'descrip'=>'For petrochemical and power generation industries', 'img' => 'images/Products/product_2.jpg'],
                ['title' => 'Foundation Bolts','descrip'=>'Custom-made for structural applications',  'img' => 'images/Products/product_2.jpg'],
                ['title' => 'U Bolts & J Bolts','descrip'=>'Manufactured as per customer drawings', 'img' => 'images/Products/product_2.jpg'],
                ['title' => 'Anchor Fasteners', 'descrip'=>'Mechanical and chemical types for heavy-duty anchoring', 'img' => 'images/Products/product_2.jpg'],
                ['title' => 'Special Fasteners', 'descrip'=>'Customised solutions for offshore, refinery, and plant-specific needs', 'img' => 'images/Products/product_2.jpg'],
            ] as $product)
                <div class="card product-card mx-2 flex-shrink-0" style="width: 300px; scroll-snap-align: start;">
                    <img src="{{ asset($product['img']) }}" class="card-img-top" style="height: 180px; object-fit: contain;" alt="{{ $product['title'] }}">
                    <div class="card-body text-center">
                        <h5 class="card-title text-secondary">{{ $product['title'] }}</h5>
                        
                        <p class="text-muted small">{{ $product['descrip'] }}</p>
                    </div>
                </div>
            @endforeach
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

<!-- Industry Footprint Graph Section (Smaller Version) -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0" style="background: linear-gradient(to right, #f0f4ff, #dceeff);">
                <div class="card-body text-center">
                    <h4 class="fw-bold text-primary mb-2">INDUSTRY <span class="text-dark">FOOTPRINT</span></h4>
                    <p class="fw-semibold mb-3">Serving Diverse Sectors</p>
                    <div class="mx-auto" style="max-width: 250px;">
                        <canvas id="industryChart" height="180"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Chart Initialization Script -->
<script>
    const ctx = document.getElementById('industryChart').getContext('2d');
    const industryChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Wind Energy', 'Engineering'],
            datasets: [{
                label: 'Business Operations',
                data: [70, 30],
                backgroundColor: [
                    'rgba(0, 123, 255, 0.7)',
                    'rgba(255, 193, 7, 0.7)'
                ],
                borderColor: [
                    'rgba(0, 123, 255, 1)',
                    'rgba(255, 193, 7, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 12
                        }
                    }
                },
                title: {
                    display: false
                }
            }
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
        const scroller = document.getElementById('productScroller');
        let scrollStep = 310; // card width + margin
        let scrollPosition = 0;

        setInterval(() => {
            if (scrollPosition + scroller.offsetWidth >= scroller.scrollWidth) {
                scrollPosition = 0;
            } else {
                scrollPosition += scrollStep;
            }
            scroller.scrollTo({
                left: scrollPosition,
                behavior: 'smooth'
            });
        }, 3000);
    });
</script>
<!-- Quality Assurance Section -->
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">QUALITY ASSURANCE</h2>
        <h5 class="fw-semibold text-dark">Commitment to Excellence</h5>
        <p class="text-muted">Upcoming state-of-the-art laboratory equipped with:</p>
    </div>

    <!-- Centered Card Wrapper -->
    <div class="mx-auto" style="max-width: 800px;">
        <div class="row gy-4">
            @foreach([
                ['icon' => 'fas fa-balance-scale', 'title' => 'Coefficient of Friction (COF) Testing Machine'],
                ['icon' => 'fas fa-hard-hat', 'title' => 'Hardness Testing Machine'],
                ['icon' => 'fas fa-dumbbell', 'title' => 'Tensile Testing Machine'],
                ['icon' => 'fas fa-vials', 'title' => 'Chemical Composition Analysis Equipment'],
                ['icon' => 'fas fa-snowflake', 'title' => 'Salt Spray Test Chamber']
            ] as $item)
                <div class="col-12">
                    <div class="card flex-row align-items-center shadow-sm border-0 p-3 bg-light rounded-4">
                        <div class="p-3 text-primary">
                            <i class="{{ $item['icon'] }} fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">{{ $item['title'] }}</h6>
                            <p class="text-muted small mb-0">
                                Ensures precise and reliable quality metrics for industrial standards.
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
    </div>
</div>
            </div>


<!-- Esteemed Clientele Section -->
<div class="container-fluid py-5" style="background: linear-gradient(to bottom right, #f5f8fd, #eaf4ff);">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bold text-primary display-6">Esteemed Clientele</h2>
                <p class="text-secondary fs-5">Trusted by Industry Leaders Across Sectors</p>
                <hr class="w-25 mx-auto border-2 border-primary">
            </div>
        </div>

        <div class="row g-4">
            <!-- Wind Energy Clients -->
            <div class="col-md-6">
                <div class="p-4 rounded-4 shadow-sm h-100 bg-white">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary text-white p-3 rounded-circle me-3">
                            <i class="fas fa-wind fa-lg"></i>
                        </div>
                        <h4 class="fw-bold mb-0 text-primary">Wind Energy Sector</h4>
                    </div>
                    <ul class="list-unstyled ps-4 mt-3 mb-0 lh-lg">
                        @foreach(['Siemens Gamesa', 'Vestas', 'Nordex', 'Adani Wind', 'Inox Wind', 'Envision Energy', 'Sany Wind', 'Renew Power'] as $client)
                            <li><i class="fas fa-check-circle text-success me-2"></i> {{ $client }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Engineering Clients -->
            <div class="col-md-6">
                <div class="p-4 rounded-4 shadow-sm h-100 bg-white">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-warning text-white p-3 rounded-circle me-3">
                            <i class="fas fa-industry fa-lg"></i>
                        </div>
                        <h4 class="fw-bold mb-0 text-warning">Engineering Sector</h4>
                    </div>
                    <ul class="list-unstyled ps-4 mt-3 mb-0 lh-lg">
                        @foreach(['Kone Elevators', 'Doosan Bobcat', 'Wheels India', 'Bull Machines', 'ELGI Equipments', 'Schneider Electric', 'Larsen & Toubro'] as $client)
                            <li><i class="fas fa-check-circle text-success me-2"></i> {{ $client }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>



            <!-- Traction Cards Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary">Traction</h2>
            <p class="text-muted fs-5">Optimizing Client Inventory</p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Card 1 -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3">
                    <div class="card-body">
                        <i class="fas fa-warehouse fa-2x text-primary mb-3"></i>
                        <h6 class="fw-bold">On-site Inventory Management</h6>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3">
                    <div class="card-body">
                        <i class="fas fa-clock fa-2x text-primary mb-3"></i>
                        <h6 class="fw-bold">Timely Replenishment</h6>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3">
                    <div class="card-body">
                        <i class="fas fa-box-open fa-2x text-primary mb-3"></i>
                        <h6 class="fw-bold">Reduced Stockouts</h6>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-3">
                    <div class="card-body">
                        <i class="fas fa-truck-moving fa-2x text-primary mb-3"></i>
                        <h6 class="fw-bold">Supply Chain Efficiency</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<style>
    .card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;

}
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}
    .product-card {
    scroll-snap-align: start;
    transition: transform 0.3s ease;
    border: none;
    border-radius: 1rem;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
}

.product-card:hover {
    transform: translateY(-5px);
}

</style>
@endsection