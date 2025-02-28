
document.addEventListener('DOMContentLoaded', function() {
    updateCartCountFromStorage();

    const addToCartButton = document.querySelector('.btn-add-to-cart');
    if (!addToCartButton) {
        console.error("Add to Cart button not found");
        return;
    }
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
                updateCartCount(data.cartCount); // Update cart count from server response
            } else {
                alert('Failed to add item: ' + data.message);
            }
        })
        .catch(error => console.error('Error adding item to cart:', error));
    });
});

function updateCartCountFromStorage() {
    const count = localStorage.getItem('cartCount') || 0;
    updateCartCount(count);
}

function updateCartCount(count) {
    const cartCountElement = document.getElementById('cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = count;
        localStorage.setItem('cartCount', count); // Persist cart count in local storage
    } else {
        console.error('Cart count element not found');
    }
}

//Update Cart Quantity in Cart
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
        console.log('Update response', data);
        if (data.success) {
            alert('Quantity updated');
            location.reload(); // Reload the page to reflect the changes
        }
    })
    .catch(error => console.error('Error updating quantity:', error));
}


//Remove Item from Cart
function removeItem(itemId) {
    if (confirm('Are you sure you want to remove this item?')) {
        fetch(`/cart/remove/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Remove response', data);
            if (data.success) {
                alert('Item removed');
                location.reload(); // Reload the page to reflect the changes
            }
        })
        .catch(error => console.error('Error removing item:', error));
    }
}

//Empty Cart
const emptyCartButton = document.getElementById('empty-cart');
    if (emptyCartButton) {
        emptyCartButton.addEventListener('click', function() {
            const emptyCartUrl = this.dataset.emptyCartUrl;
            fetch(emptyCartUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    updateCartCount(0); // Update cart count to 0 in the UI
                    localStorage.setItem('cartCount', 0); // Optionally update local storage
                } else {
                    alert('Failed to empty cart: ' + data.message);
                }
            })
            .catch(error => console.error('Error emptying cart:', error));
        });
    }

document.getElementById('checkout').addEventListener('click', function() {
    window.location.href = '/checkout'; // Redirect to the checkout page
});

