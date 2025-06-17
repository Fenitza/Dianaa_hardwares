@extends('layouts.app')
<title>About Us-Dianaa Fasteners</title>

@section('content')
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f9fbfd;
      color: #333;
    }
    .hero {
      background: linear-gradient(rgba(0,0,0,.6), rgba(0,0,0,.6)), url('images/banners/about_us.png') no-repeat center center/cover;
      height: 80vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
    }
    .hero h1 {
      font-size: 3rem;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .hero p {
      font-size: 1.3rem;
    }
    .section {
      padding: 60px 0;
    }
    .about-title {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 20px;
      text-align: center;
      position: relative;
    }
    .about-title::after {
      content: '';
      width: 80px;
      height: 4px;
      background-color: #0d6efd;
      display: block;
      margin: 10px auto 0;
      border-radius: 2px;
    }
    .who-we-are-section {
    position: relative;
    background: url('{{ asset('images/banners/people.jpg') }}') no-repeat center center/cover;
    z-index: 1;
    padding: 80px 0; /* adjust as needed */
    overflow: hidden;

}

.who-we-are-section::before {
    content: "";
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: linear-gradient(
        rgba(0, 0, 0, 0.4),  /* top color */
        rgba(0, 0, 0, 0.4)   /* bottom color */
    );
    z-index: -1;
}
    .info-box {
      background: white;
      padding: 40px 25px;
      text-align: center;
      border-radius: 10px;
      box-shadow: 0 0 25px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
    }
    .info-box:hover {
      transform: translateY(-5px);
    }
    .info-box i {
      font-size: 2rem;
      color: #0d6efd;
      margin-bottom: 15px;
    }
    .info-box h5 {
      font-size: 1.1rem;
      margin-bottom: 10px;
    }
    .info-box p {
      font-size: 1.3rem;
      font-weight: bold;
    }
    .card-box {
      background: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.06);
      margin-bottom: 20px;
    }
    footer {
      background: #0d6efd;
      color: white;
      padding: 40px 0;
    }
    .core-process-section {
        background-color: #f7f9fb;
        padding: 60px 20px;
    }

    .core-process-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #222;
    }

    .core-process-subtitle {
        font-size: 1rem;
        color: #666;
        margin-bottom: 50px;
    }

    .core-card {
        text-align: center;
        padding: 20px;
        background-color: white;
        border-radius: 16px;
        transition: transform 0.3s;
        height: 100%;
    }

    .core-card:hover {
        transform: translateY(-5px);
    }

    .core-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 30px;
        margin: 0 auto 20px;
    }

    .bg-blue { background-color: #00bcd4; }
    .bg-purple { background-color: #673ab7; }
    .bg-pink { background-color: #e91e63; }
    .bg-orange { background-color: #ff9800; }

    .core-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
    }

    .core-description {
        color: #666;
        font-size: 0.95rem;
    }

    .infra-section {
        background: linear-gradient(to bottom, #f4f7fa, #e6ecf2);
        padding: 80px 20px;
        position: relative;
    }

    .infra-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #004085;
        text-align: center;
    }

    .infra-subtitle {
        text-align: center;
        color: #333;
        margin-bottom: 60px;
        font-size: 1.1rem;
    }

    .infra-cards {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
    }

    .infra-card {
        background: linear-gradient(to right, #ccd9e9, #f8f9fb);
        border-left: 6px solid #004085;
        padding: 30px;
        border-radius: 15px;
        max-width: 320px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease;
    }

    .infra-card:hover {
        transform: translateY(-5px);
    }

    .infra-location {
        font-size: 1rem;
        font-weight: bold;
        color: #004085;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .infra-size {
        font-size: 1.8rem;
        font-weight: 800;
        color: #000;
        margin-top: 10px;
    }

    .infra-note {
        font-size: 0.9rem;
        color: #555;
        margin-top: 5px;
    }

    @media (max-width: 768px) {
        .infra-cards {
            flex-direction: column;
            align-items: center;
        }
    }
    .vm-container{
    max-width: 900px;  /* Reduced max-width */
    margin: 0 auto;
    padding-top:20px;
    }

    .financial-section {
        background: linear-gradient(to right, #f3f6fb, #e9eef5);
        padding: 80px 30px;
        text-align: center;
    }

    .financial-title {
        font-size: 2.8rem;
        font-weight: 800;
        color: #003366;
        margin-bottom: 10px;
    }

    .financial-subtitle {
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 60px;
        font-weight: 500;
    }

    .graph-steps {
        display: flex;
        justify-content: center;
        gap: 40px;
        flex-wrap: wrap;
        position: relative;
    }

    .graph-steps::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 8%;
        width: 84%;
        height: 4px;
        background-color: #cfd8e5;
        z-index: 0;
    }

    .step-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        padding: 30px 25px;
        max-width: 280px;
        position: relative;
        z-index: 1;
        text-align: center;
        transition: all 0.3s ease;
    }

    .step-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .step-icon {
        font-size: 35px;
        color: #0056b3;
        margin-bottom: 15px;
    }

    .step-title {
        font-size: 1rem;
        font-weight: 700;
        color: #004085;
        text-transform: uppercase;
    }

    .step-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: #111;
        margin-top: 10px;
    }

    .step-line-connector {
        position: relative;
        top: -30px;
        width: 100%;
        text-align: center;
        z-index: 2;
    }

    @media (max-width: 768px) {
        .graph-steps::before {
            display: none;
        }

        .graph-steps {
            flex-direction: column;
            gap: 60px;
        }
    }
    .certification-section {
        background: linear-gradient(to right, #f6f9fc, #eef3f9);
        padding: 80px 30px;
    }

    .certification-container {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .certification-images {
        flex: 1;
        display: grid;
        gap: 20px;
        grid-template-columns: 1fr 1fr;
    }
    .cert-image {
    width: 200px;
    height: 200px;
    position: center;
    
    overflow: hidden;
    transition: transform 0.3s ease;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

    .certification-images img {
        width: 100%;
        height: auto;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .certification-content {
        flex: 1;
        min-width: 320px;
    }

    .certification-title {
        font-size: 2.2rem;
        color: #003366;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .certification-subtitle {
        font-size: 1rem;
        color: #333;
        margin-bottom: 30px;
        font-weight: 500;
    }

    .certification-points {
        font-size: 1rem;
        color: #222;
    }

    .certification-points li {
        margin-bottom: 15px;
        font-weight: 600;
        line-height: 1.5;
        list-style-type: disc;
        padding-left: 10px;
    }

    @media (max-width: 768px) {
        .certification-container {
            flex-direction: column;
            text-align: center;
        }

        .certification-images {
            grid-template-columns: 1fr;
        }
    }
    .team-section {
        background: linear-gradient(to right, #eef2f7, #f7f9fc);
        padding: 80px 20px;
        text-align: center;
    }

    .team-section h2 {
        font-size: 2.8rem;
        color: #003366;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .team-section .subtitle {
        font-size: 1.2rem;
        font-weight: 600;
        color: #444;
        margin-bottom: 60px;
    }

    .team-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .team-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        padding: 30px 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .team-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .team-card img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        margin-bottom: 20px;
        border: 4px solid #003366;
    }

    .team-role {
        font-size: 1.1rem;
        color: #003366;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .team-desc {
        font-size: 0.95rem;
        color: #555;
    }

  </style>
</head>
<body>
  <!-- <header class="hero">
    <div>
      <h1>About Dianaa Fasteners</h1>
      <p>Engineering Excellence for Tomorrow's Industries</p>
    </div>
  </header> -->

  

  
  <section class="section who-we-are-section" >
  <main  class="container">
      <h2 class="about-title "style="color:white;">Who We Are</h2>
      <div class="row g-4 center">
        <div class="col-md-5">
          <img src="{{ asset('images/logo/Diana_logo2.jpg') }}" alt="Dianaa Fasteners Team" class="img-fluid">
        </div>
        <div class="col-md-7">
          <div class="card-box">
            <p>Dianaa Fasteners is the largest distributor of TVS Fasteners in India and a leading provider of engineered fastening solutions. With a footprint across vital industrial sectors, we champion innovation, precision, and excellence.</p>
            <p>Our infrastructure, experience, and in-house technical capabilities allow us to serve diverse industrial needs with unmatched quality and timely delivery. We are proud to be at the forefront of India’s industrial supply chain.</p>
          </div>
        </div>
      </div>
      <div class="row g-4">
        <div class="col-md-3">
          <div class="info-box">
            <i class="fas fa-rupee-sign"></i>
            <h5>Annual Turnover</h5>
            <p>₹500 Million Annual Turnover</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info-box">
            <i class="fas fa-users"></i>
            <h5>Employees</h5>
            <p>250 and plus Employees</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info-box">
            <i class="fas fa-location-dot"></i>
            <h5>Locations</h5>
            <p>Coimbatore & Chennai</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info-box">
            <i class="fas fa-location-dot"></i>
            <h5>ERP System</h5>
            <p>Integrated Since since 2021</p>
          </div>
        </div>
      </div>
</main>
    </section>


    
    
    <section class="vm-container">
  <h2  class="about-title">Vision & Mission</h2>
  <div class="row g-4">
    <div class="col-md-6">
      <div class="card h-100 text-center p-4 border-0 shadow rounded-4" style="border-top: 5px solid #0d6efd;">
        <img src="https://cdn-icons-png.flaticon.com/512/2936/2936884.png" alt="Vision Icon" width="60" class="mb-3 mx-auto center">
        <h5 class="text-primary">Vision</h5>
        <p>To be the global benchmark in fastening technology.</p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card h-100 text-center p-4 border-0 shadow rounded-4" style="border-top: 5px solid #fd7e14;">
        <img src="https://cdn-icons-png.flaticon.com/512/684/684908.png" alt="Mission Icon" width="60" class="mb-3 mx-auto">
        <h5 class="text-warning">Mission</h5>
        <p>Delivering precision-engineered fasteners that empower industries worldwide.</p>
      </div>
    </div>
  </div>
</section>

<div class="core-process-section text-center">
    <div class="container">
        <h2 class="about-title">Core Competencies</h2>
        <p class="core-process-subtitle">What Sets Us Apart</p>

        <div class="row justify-content-center g-4">
            <!-- Card 1 -->
            <div class="col-md-6 col-lg-3">
                <div class="core-card">
                    <div class="core-icon bg-blue">
                        <i class="fas fa-industry"></i>
                    </div>
                    <div class="core-title">Largest Distributor</div>
                    <div class="core-description">TVS Fasteners in India</div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-6 col-lg-3">
                <div class="core-card">
                    <div class="core-icon bg-purple">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="core-title">Timely Deliveries</div>
                    <div class="core-description">Adherence to client schedules</div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-6 col-lg-3">
                <div class="core-card">
                    <div class="core-icon bg-pink">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="core-title">Advanced Coating</div>
                    <div class="core-description">In-house Zinc Flake Coating Facility</div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-md-6 col-lg-3">
                <div class="core-card">
                    <div class="core-icon bg-orange">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div class="core-title">Customized Solutions</div>
                    <div class="core-description">Kitting as per client specifications</div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<div class="infra-section">
    <div class="container">
        <h2 class="infra-title">Strategic Infrastructure</h2>
        <p class="infra-subtitle">Facilities Designed for Excellence</p>

        <div class="infra-cards">
            <!-- Coimbatore Unit -->
            <div class="infra-card">
                <div class="infra-location">Coimbatore Unit</div>
                <div class="infra-size">20,000 SQ. FT.</div>
            </div>

            <!-- Chennai Unit -->
            <div class="infra-card">
                <div class="infra-location">Chennai Unit</div>
                <div class="infra-size">30,000 SQ. FT.</div>
                <div class="infra-note">With Advanced Coating Capabilities</div>
            </div>
        </div>
    </div>
</div>

<!-- FontAwesome CDN (for icons) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>

<div class="financial-section">
    <h2 class="financial-title">Financial Highlights</h2>
    <p class="financial-subtitle">Robust Growth Trajectory</p>

    <div class="graph-steps">

        <!-- Step 1 -->
        <div class="step-card">
            <div class="step-icon"><i class="fas fa-chart-line"></i></div>
            <div class="step-title">Annual Turnover</div>
            <div class="step-value">₹500 Million</div>
        </div>

        <!-- Step 2 -->
        <div class="step-card">
            <div class="step-icon"><i class="fas fa-bullseye"></i></div>
            <div class="step-title">YOY Growth Target</div>
            <div class="step-value">20%</div>
        </div>

        <!-- Step 3 -->
        <div class="step-card">
            <div class="step-icon"><i class="fas fa-industry"></i></div>
            <div class="step-title">Market Share</div>
            <div class="step-value">60%</div>
            <div class="step-title" style="font-size: 0.85rem; font-weight: 500; color: #555;">(Small Wind Fasteners)</div>
        </div>
    </div>
</div>

<div class="certification-section">
    <div class="certification-container">
        <!-- Images (Left Side) -->
        <div class="certification-images">
        <div class="cert-image">
            <img src="{{ asset('images/banners/certificate_1.jpg') }}" alt="Certification Photo 1">
        </div>
        <div class="cert-image">
            <img src="{{ asset('images/banners/cert_2.png') }}" alt="Certification Photo 2">
        </div>
    </div>

        <!-- Content (Right Side) -->
        <div class="certification-content">
            <h2 class="certification-title">CERTIFICATIONS & COMPLIANCE</h2>
            <p class="certification-subtitle">Adhering to Global Standards</p>
            <ul class="certification-points">
                <li>ISO 9001:2015 Certified</li>
                <li>Compliance with international quality standards</li>
                <li>Regular audits to ensure excellence</li>
            </ul>
        </div>
    </div>
</div>
<div class="team-section">
    <h2>Our Team</h2>
    <div class="subtitle">Driven by Expertise</div>

    <div class="team-cards">
        <div class="team-card">
            <img src="{{ asset('images/banners/people.jpg') }}" alt="Leadership">
            <div class="team-role">Leadership</div>
            <div class="team-desc">Visionary Professionals</div>
        </div>

        <div class="team-card">
            <img src="{{ asset('images/banners/hand_tools.jpg') }}" alt="Engineering">
            <div class="team-role">Engineering</div>
            <div class="team-desc">Skilled Engineers</div>
        </div>

        <div class="team-card">
            <img src="{{ asset('images/banners/quality.jpg') }}" alt="Quality Assurance">
            <div class="team-role">Quality Assurance</div>
            <div class="team-desc">Dedicated Team</div>
        </div>

        <div class="team-card">
            <img src="{{ asset('images/banners/culture.jpg') }}" alt="Customer Support">
            <div class="team-role">Customer Support</div>
            <div class="team-desc">Responsive Personnel</div>
        </div>
    </div>
</div>

@endsection
