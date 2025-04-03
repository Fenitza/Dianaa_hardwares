@extends('layouts.app')

@section('content')
    

    <!-- Hero Section -->
    <section class="container mt-5" style="background-image: url('{{ asset('images/banners/contact.jpg') }}'); background-size: cover; background-position: center; height: 300px;">
        <h1>Contact Us</h1>
        <p>Get in touch</p>
    </section>

    <!-- Contact Details and Form -->
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">
                <h4>Visit Us:</h4>
                <p>99-100 Srikant Ext, Grey Town,
                    <br> Coimbatore-641018,
                    <br> Tamil Nadu, India.</p>
                <h4>Call Us:</h4>
                <p>+91 95662 75630</p>
                <h4>Mail Us:</h4>
                <p>mkt1@dhw.co.in</p>
            </div>
            <div class="col-md-6">
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email</label>
                        <input type="email" class="form-control" id="email">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Form</button>
                </form>
            </div>
        </div>
    </div>


@endsection
