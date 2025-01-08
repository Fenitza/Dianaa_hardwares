{{-- resources/views/cart/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Shopping Cart</h1>
    @if(count($cartItems) > 0)
        <ul>
            @foreach($cartItems as $item)
                <li>{{ $item->name }} - {{ $item->quantity }}</li>
            @endforeach
        </ul>
    @else
        <p>Your cart is empty.</p>
    @endif
@endsection
