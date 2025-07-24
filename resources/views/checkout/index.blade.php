@extends('layouts.app')
<title>Checkout-Dianaa Fasteners</title>
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
                        <p class="fw-semibold text-dark mb-1">{{ $item->product->Description }}</p>
                            
                            <p class="text-muted small mb-1">Color: {{ $item->selected_color ?? 'N/A' }}</p>
                            <p class="text-muted small mb-0">
                                Price: ₹{{ number_format($item->selected_price, 2) }} x {{ $item->quantity }}<br>
                                <strong class="text-dark">Total: ₹{{ number_format($item->selected_price * $item->quantity, 2) }}</strong>
                            </p>
                            <p class="text-muted small mb-0"><strong>Net Weight:</strong> {{ number_format($netWeight, 2) }} g</p>
                        </div>
                    </div>
                @endforeach 

                <hr>
                <div class="mb-2 text-muted">
                    <strong>Total Net Weight:</strong> {{ number_format($netWeight, 2) }} g
                </div>

                <div class="mb-2">
                    <strong>Shipping Charges:</strong> ₹<span id="shippingCharge">--</span>
                </div>

                <div class="fs-5 fw-bold text-success">
                    <strong>Grand Total:</strong> ₹<span id="grandTotal">{{ number_format($total, 2) }}</span>
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

                    <input type="hidden" id="net_weight" value="{{ $netWeight }}">
                    <input type="hidden" id="base_total" value="{{ $total }}">

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
                    <button type="button" class="btn btn-primary btn-sm w-100 mt-2" id="place-order-btn" disabled>
                        🛒 Place Order
                    </button>
                    <button type="button" class="btn btn-success btn-sm w-100 mt-2" id="pay-btn" disabled>
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
    #pay-btn:disabled {
        opacity: 0.6;
        pointer-events: none;
    }
</style>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const postalInput = document.getElementById('postal_code');
    const shippingChargeEl = document.getElementById('shippingCharge');
    const grandTotalEl = document.getElementById('grandTotal');
    const placeOrderButton = document.getElementById('place-order-btn');
    const payButton = document.getElementById('pay-btn');

    let baseTotal = {{ $total }};
    let weight = {{ $netWeight }};
    let shippingCharge = 0;

    postalInput.addEventListener('blur', function () {
        const pincode = this.value.trim();

        shippingCharge = 0;
        shippingChargeEl.textContent = '--';
        grandTotalEl.textContent = baseTotal.toFixed(2);
        placeOrderButton.disabled = true;
        payButton.disabled = true;
        payButton.innerHTML = `💳 Pay Now ₹${baseTotal.toFixed(2)}`;

        if (!/^\d{6}$/.test(pincode)) return;

        fetch('/bluedart/shipping-charge', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ pincode, weight })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                shippingCharge = parseFloat(data.shipping_charge);
                const newTotal = baseTotal + shippingCharge;

                shippingChargeEl.textContent = shippingCharge.toFixed(2);
                grandTotalEl.textContent = newTotal.toFixed(2);
                payButton.innerHTML = `💳 Pay Now ₹${newTotal.toFixed(2)}`;
                placeOrderButton.disabled = false;
            } else {
                shippingChargeEl.textContent = 'N/A';
            }
        })
        .catch(() => {
            shippingChargeEl.textContent = 'Error';
        });
    });

    placeOrderButton.addEventListener('click', function (event) {
        event.preventDefault();
        const grandTotal = parseFloat(grandTotalEl.textContent) || baseTotal;

        const formData = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            address: document.getElementById('address').value,
            city: document.getElementById('city').value,
            state: document.getElementById('state').value,
            postal_code: document.getElementById('postal_code').value,
            country: document.getElementById('country').value,
            total: grandTotal
        };

        fetch('/place-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                window._placedOrderId = data.order_id;
                alert("✅ Order placed successfully.");
                payButton.disabled = false;
            } else {
                alert("❌ Order placement failed.");
            }
        })
        .catch(error => {
            console.error('Order Error:', error);
            alert('❌ Order processing failed.');
        });
    });

    payButton.addEventListener('click', function () {
        const grandTotal = parseFloat(grandTotalEl.textContent) || baseTotal;
        const amountInPaise = Math.round(grandTotal * 100);

        fetch('/create-razorpay-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                amount: amountInPaise,
                order_id: window._placedOrderId
            })
        })
        .then(response => response.json())
        .then(data => {
            var options = {
                "key": "{{ config('services.razorpay.key') }}",
                "amount": data.amount,
                "currency": "INR",
                "name": "Dianaa Fasteners",
                "description": "Order Payment",
                "order_id": data.id,
                "handler": function (response) {
                    fetch('/razorpay-payment-success', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_signature: response.razorpay_signature
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert("✅ Payment Successful! Transaction ID: " + response.razorpay_payment_id);
                            window.location.href = "/checkout/success";
                        } else {
                            alert("⚠️ Payment recorded but order not updated.");
                        }
                    })
                    .catch(error => {
                        console.error("Error saving payment:", error);
                        alert("❌ Payment success, but server update failed.");
                    });
                },
                "prefill": {
                    "name": document.getElementById('name').value,
                    "email": document.getElementById('email').value,
                    "contact": document.getElementById('phone').value
                },
                "theme": {
                    "color": "#F6793F"
                }
            };
            var rzp = new Razorpay(options);
            rzp.open();
        })
        .catch(error => {
            console.error('Payment Error:', error);
            alert("Failed to initiate payment.");
        });
    });
});
</script>
@endsection
