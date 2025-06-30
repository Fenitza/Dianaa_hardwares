@extends('layouts.app')
<title>Careers - Dianaa Fasteners</title>
@section('content')

<!-- Hero Section -->
<section class="hero-section" style="background-image: url('{{ asset('images/banners/careers.jpg') }}'); background-size: cover; background-position: center; height: 300px;">
    <div class="container text-center py-5"></div>
</section>

<!-- Main Content Section -->
<div class="container py-5">

    <div class="row mt-5" id="work-with-us">
        <div class="col-md-6 work-with-us-text mb-4">
            <h2>Why Work With Us?</h2>
            <p>Discover the benefits and perks of joining our team.</p>
            <ul>
                <li>Competitive salaries and comprehensive health benefits</li>
                <li>Flexible working hours and remote work options</li>
                <li>Inclusive and dynamic company culture</li>
            </ul>
        </div>
        <div class="col-md-6 work-with-us-image mb-4">
            <img src="{{ asset('images/banners/culture.jpg') }}" alt="Our Company Culture" class="img-fluid">
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12 text-center">
            <h2>Ready to start your journey?</h2>
            <p>Apply today and make a real impact tomorrow.</p>
            <a href="#job-form" class="btn btn-success">Submit Your Application</a>
        </div>
    </div>

</div>

<div class="job-form" id="job-form">
    <form action="{{ route('job.application.send') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>First Name *</label>
            <input type="text" name="first_name" required>
        </div>

        <div class="form-group">
            <label>Last Name *</label>
            <input type="text" name="last_name" required>
        </div>

        <div class="form-group">
            <label>Date of Birth *</label>
            <input type="date" name="dob" required>
        </div>

        <div class="form-group">
            <label>Gender *</label>
            <select name="gender" required>
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address">
        </div>

        <div class="form-group">
            <label>Pincode</label>
            <input type="text" name="pincode">
        </div>

        <div class="form-group">
            <label>City</label>
            <input type="text" name="city">
        </div>

        <div class="form-group">
            <label>Mobile *</label>
            <input type="text" name="mobile" required>
        </div>

        <div class="form-group">
            <label>Email ID *</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Total Experience</label>
            <input type="text" name="total_exp">
        </div>

        <div class="form-group">
            <label>Qualification *</label>
            <input type="text" name="qualification" required>
        </div>

        <div class="form-group">
            <label>Present Job</label>
            <input type="text" name="present_job">
        </div>

        <div class="form-group">
            <label>Current CTC</label>
            <input type="text" name="current_ctc">
        </div>

        <div class="form-group">
            <label>Notice Period</label>
            <input type="text" name="notice_period" placeholder="Type in Months">
        </div>

        <div class="form-group">
            <label>Expected CTC *</label>
            <input type="text" name="expected_ctc" required>
        </div>

        <div class="form-group">
            <label>Upload Resume *</label>
            <input type="file" name="resume" accept=".pdf,.doc,.docx" required>
        </div>

        <div class="form-group text-center">
            <button type="submit">Send</button>
        </div>
    </form>
</div>

<style>
    .job-form {
        max-width: 800px;
        margin: 30px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #f9f9f9;
    }

    .job-form .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 15px;
    }

    .job-form label {
        margin-bottom: 5px;
        font-weight: 600;
    }

    .job-form input,
    .job-form select {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    .job-form input[type="file"] {
        padding: 5px;
    }

    .job-form button {
        padding: 10px 25px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .job-form button:hover {
        background-color: #218838;
    }

    /* Responsive Styling */
    @media (max-width: 768px) {
        .job-form {
            padding: 15px;
        }

        .job-form input,
        .job-form select {
            font-size: 16px;
        }
    }

    @media (max-width: 576px) {
        .job-form {
            width: 90%;
        }

        .job-form button {
            width: 100%;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endsection
