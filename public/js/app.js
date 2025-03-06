document.addEventListener('DOMContentLoaded', function() {
    fetchCartCount(); // Fetch initial cart count from the server on page load

    // Add to Cart Functionality
    document.querySelectorAll('.btn-add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const cartAddUrl = this.getAttribute('data-cart-add-url');
            const quantity = document.getElementById('quantity') ? document.getElementById('quantity').value : 1;

            console.log("Sending Product ID:", productId); // Debugging line

            fetch(cartAddUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Response from Server:", data);
                if (data.status === 'success') {
                    alert('Item added to cart!');
                    fetchCartCount(); // Refresh cart count
                    location.reload(); // Reload to update cart page
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error adding item to cart:', error));
        });
    });

    // Update Quantity in Cart
    document.querySelectorAll('.cart-table input[type="number"]').forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.closest('tr').dataset.itemId;
            const newQuantity = this.value;

            updateQuantity(itemId, newQuantity);
        });
    });

    // Remove Item from Cart
    document.querySelectorAll('.btn-remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            removeItem(itemId);
        });
    });

    // Empty Cart
    const emptyCartButton = document.getElementById('empty-cart');
    if (emptyCartButton) {
        emptyCartButton.addEventListener('click', function() {
            if (confirm('Are you sure you want to empty the cart?')) {
                emptyCart();
            }
        });
    }
});

// Fetch Cart Count
function fetchCartCount() {
    fetch('/cart/count', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        updateCartCount(data.cartCount); // Update count from server response
    })
    .catch(error => console.error('Error fetching cart count:', error));
}

// Update Cart Count in UI
function updateCartCount(count) {
    const cartCountElement = document.getElementById('cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = count;
        localStorage.setItem('cartCount', count); // Optionally update local storage
    } else {
        console.error('Cart count element not found');
    }
}

// Update Item Quantity in Cart
function updateQuantity(itemId, newQuantity) {
    fetch(`/cart/update/${itemId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ quantity: newQuantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Quantity updated');
            location.reload(); // Reload page to reflect updated quantity
         } 
        // else {
        //     alert('Failed to update quantity: ' + data.message);
        // }
    })
    .catch(error => console.error('Error updating quantity:', error));
}

// Remove Item from Cart
function removeItem(itemId) {
    fetch(`/cart/remove/${itemId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Item removed from cart');
            location.reload(); // Reload page to update cart
        } else {
            alert('Failed to remove item: ' + data.message);
        }
    })
    .catch(error => console.error('Error removing item:', error));
}

// Empty Cart Functionality
function emptyCart() {
    fetch('/cart/empty', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Cart emptied');
            updateCartCount(0); // Update cart count to 0 in the UI
            localStorage.setItem('cartCount', 0);
            location.reload(); // Reload to reflect empty cart
        } else {
            alert('Failed to empty cart: ' + data.message);
        }
    })
    .catch(error => console.error('Error emptying cart:', error));
}

// Checkout Button Redirect
document.getElementById('checkout').addEventListener('click', function() {
    window.location.href = '/checkout'; // Redirect to the checkout page
});
