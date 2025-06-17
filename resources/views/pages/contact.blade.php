@extends('layouts.app')
<title>Contact-Dianaa Fasteners</title>
@section('content')
    

    <!-- Hero Section -->

<section class="bg-dark text-white text-center py-5 position-relative" style="background: url('{{ asset('images/banners/contact.jpg') }}') center/cover no-repeat; height: 80vh;">
  <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50"></div>
  <div class="container position-relative d-flex flex-column justify-content-center align-items-center h-100">
    <h1 class="display-4 fw-bold">Engineering Excellence Delivered</h1>
    <p class="lead mb-4">Tailored fasteners and precision manufacturing for high-performance applications</p>
    <a href="#contact" class="btn btn-primary px-4 py-2 rounded-pill">Get in Touch</a>
  </div>
</section>


    <!-- Contact Page Section -->
<section class="py-5 bg-light">
    <div class="container">
        <!-- Header -->
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary">CONTACT US</h2>
            <p class="fs-5">Let's Build the Future Together</p>
        </div>

        <div class="row g-4">
            <!-- Contact Info -->
            <div class="col-lg-6">
                <div class="bg-white shadow-sm p-4 rounded-4">
                    <h5 class="text-primary fw-bold">DIANAA Fasteners</h5>
                    <p class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i> A26/2C SIPCOT INDUSTRIAL PARK,<br> Pillaipakkam, Sriperumbudur Taluk,<br> Chennai, Tamil Nadu 602105</p>
                    <p><i class="fas fa-phone-alt me-2 text-primary"></i> +91 80726 41235</p>
                    <p><i class="fas fa-envelope me-2 text-primary"></i> sales@dhw.co.in</p>

                    <hr>

                    <h5 class="text-primary fw-bold">DIANAA Fasteners</h5>
                    <p class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i> SF No. 141, Vilankuruchi Road,<br> Sri Kumaran Nagar, Vilankuruchi,<br> Coimbatore, Tamil Nadu 641035</p>
                    <p><i class="fas fa-phone-alt me-2 text-primary"></i> +91 70104 25330</p>
                    <p><i class="fas fa-envelope me-2 text-primary"></i> info@dianaahardwares.com</p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-6">
                <div class="bg-white shadow-sm p-4 rounded-4">
                    <h5 class="mb-4 text-primary">Get in Touch</h5>
                    <form method="POST" action="{{ route('contact.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Your Name</label>
                            <input type="text" name="name" class="form-control rounded-3" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control rounded-3" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control rounded-3">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" rows="4" class="form-control rounded-3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary px-4 rounded-pill">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
