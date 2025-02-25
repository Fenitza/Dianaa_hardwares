
document.addEventListener('DOMContentLoaded', function() {
    const addToCartButton = document.querySelector('.btn-add-to-cart');
    const cartAddUrl = addToCartButton.dataset.cartAddUrl;


    addToCartButton.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        const quantity = document.getElementById('quantity').value;

        fetch(cartAddUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ product_id: productId, quantity: quantity })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                alert('Item added to cart!');
                updateCartCount(data.cartCount);
            } else {
                alert('Failed to add item: ' + data.message);
            }
        })
        .catch(error => console.error('Error adding item to cart:', error));
    });
});

// Example function to update cart count in the UI
function updateCartCount(count) {
    const cartCountElement = document.getElementById('cart-count'); // Ensure this ID exists in your HTML
    if (cartCountElement) {
        cartCountElement.textContent = `Cart(${count})`; // Update the text content of the cart count element
    }
}

