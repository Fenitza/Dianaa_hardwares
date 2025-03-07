@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2 class="text-primary text-center fw-bold mb-3">🛒 Checkout</h2>

    <div class="row">
        <!-- Order Summary -->
        <div class="col-md-6">
            <section class="order-summary card shadow-sm p-3 border-0 rounded-3">
                <h4 class="text-dark fw-bold mb-2">
                    <i class="fas fa-shopping-cart"></i> Order Summary
                </h4>
                <hr class="mb-3">

                @foreach ($cartItems as $item)
                    <div class="d-flex align-items-center my-2">
                        <div class="me-2">
                            <img src="{{ asset('storage/' . $item->product->product_image) }}" 
                                 alt="{{ $item->product->Name }}" 
                                 class="rounded border" 
                                 style="width: 60px; height: 60px;">
                        </div>
                        <div>
                            <p class="fw-semibold text-dark mb-1">{{ $item->product->Name }}</p>
                            <p class="text-muted small mb-0">
                                ₹{{ number_format($item->price, 2) }} x {{ $item->quantity }}
                            </p>
                        </div>
                    </div>
                @endforeach

                <hr>
                <div class="d-flex justify-content-between small">
                    <span class="fw-semibold text-secondary">Subtotal:</span>
                    <span class="text-dark">₹{{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between small">
                    <span class="fw-semibold text-secondary">Shipping:</span>
                    <span class="text-dark">₹{{ number_format($shippingCost, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between fs-5 fw-bold text-primary mt-2">
                    <span>Total:</span>
                    <span>₹{{ number_format($total, 2) }}</span>
                </div>
            </section>
        </div>

        <!-- Billing & Payment -->
        <div class="col-md-6">
            <section class="billing-info card shadow-sm p-3 border-0 rounded-3">
                <h4 class="text-dark fw-bold mb-2">
                    <i class="fas fa-credit-card"></i> Billing & Payment
                </h4>
                <hr class="mb-3">

                <form id="order-form">
                    @csrf
                    
                    <!-- Billing Details -->
                    <div class="mb-2">
                        <label class="form-label small">Full Name</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name" 
                               value="{{ Auth::user()->name ?? '' }}" placeholder="Full Name" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Email</label>
                        <input type="email" class="form-control form-control-sm" id="email" name="email" 
                               value="{{ Auth::user()->email ?? '' }}" placeholder="Email" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Mobile</label>
                        <input type="text" class="form-control form-control-sm" id="phone" name="phone"
                               value="{{ Auth::user()->phone_number ?? '' }}" placeholder="9876543210" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Billing Address</label>
                        <input type="text" class="form-control form-control-sm" id="address" name="address" 
                               value="{{ Auth::user()->billing_address ?? '' }}" placeholder="123 Street Name" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label small">City</label>
                            <input type="text" class="form-control form-control-sm" id="city" name="city" 
                                   value="{{ Auth::user()->billing_city ?? '' }}" placeholder="City" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label small">State</label>
                            <input type="text" class="form-control form-control-sm" id="state" name="state" 
                                   value="{{ Auth::user()->billing_state ?? '' }}" placeholder="State" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label small">Postal Code</label>
                            <input type="text" class="form-control form-control-sm" id="postal_code" name="postal_code" 
                                   value="{{ Auth::user()->billing_postal_code ?? '' }}" placeholder="123456" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label small">Country</label>
                            <input type="text" class="form-control form-control-sm" id="country" name="country" 
                                   value="{{ Auth::user()->billing_country ?? '' }}" placeholder="Country" required>
                        </div>
                    </div>
                    
                    <!-- Buttons -->
                    <button type="button" class="btn btn-primary btn-sm w-100 mt-2" id="place-order-btn">
                        🛒 Place Order
                    </button>

                    <button type="button" class="btn btn-success btn-sm w-100 mt-2" id="pay-btn">
                        💳 Pay Now ₹{{ number_format($total, 2) }}
                    </button>
                </form>
            </section>
        </div>
    </div>
</div>

<style>
    .order-summary, .billing-info {
        transition: box-shadow 0.3s ease-in-out;
    }
    .order-summary:hover, .billing-info:hover {
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
    }
    .btn-primary, .btn-success {
        font-size: 14px;
        font-weight: 600;
        padding: 8px;
    }
</style>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const placeOrderButton = document.getElementById('place-order-btn');
    if (placeOrderButton) {
        placeOrderButton.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the default form submission

            // Fetch all necessary input values
            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                address: document.getElementById('address').value,
                city: document.getElementById('city').value,
                state: document.getElementById('state').value,
                postal_code: document.getElementById('postal_code').value,
                country: document.getElementById('country').value,
            };

            // Use the Fetch API to send the form data
            fetch('/place-order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Laravel CSRF token
                },
                body: JSON.stringify(formData)
            })
            .then(response => {
    if (response.ok) {
        window.location.href = "/checkout/success";  // Directly redirect on the client side
    } else {
        throw new Error('Failed to place order');
    }
})
.catch(error => {
    console.error('Order Error:', error);
    alert('Order processing failed. Please try again.');
});
        });
    }
});

document.getElementById('pay-btn').addEventListener('click', function() {
    fetch('/create-razorpay-order', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ amount: "{{ $total * 100 }}" })
    })
    .then(response => response.json())
    .then(data => {
        var options = {
            "key": "{{ env('RAZORPAY_KEY') }}",
            "amount": data.amount,
            "currency": "INR",
            "name": "Dianaa Fasteners",
            "order_id": data.id,
            "handler": function (response){
                alert("Payment Successful! Transaction ID: " + response.razorpay_payment_id);
                window.location.href = "/checkout/success";
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
    })
    .catch(error => console.error('Payment Error:', error));
});
</script>
@endsection
