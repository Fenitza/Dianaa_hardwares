{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="hero-section" style="background-image: url('{{ asset('images/hand_tools2.jpg') }}'); background-size: cover; background-position: center; color: white;">
        <div class="hero-content">
            <p>30% Discount</p>
            <h1>Best Hand Tools <br> Collection</h1>
            <a href="#" class="shop-now-btn">Shop Now</a>
        </div>
    </div>

    <div class="company-details">
    <div class="company-text">
        <h2>We are Construction - <span class="intro">Leading provider of industrial and mechanical solutions.</span></h2>
        <p>Founded in 1970, our company has grown by leaps and bounds and had been setting new standards.<br> Starting put with only ability, enthusiasm and a clear vision of destination, our team has earned every single reputation and award.</p>
    </div>
    <div class="services">
        <div class="service-item">
            <i class="fas fa-hammer fa-3x"></i>
            <p>Construction</p>
        </div>
        <div class="service-item">
            <i class="fas fa-paint-roller fa-3x"></i>
            <p>Renovations</p>
        </div>
        <div class="service-item">
            <i class="fas fa-seedling fa-3x"></i>
            <p>Green Building</p>
        </div>
    </div>
</div>
</div>

@endsection
