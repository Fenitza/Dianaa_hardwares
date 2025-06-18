document.addEventListener('DOMContentLoaded', function() {
    if (document.body.classList.contains('authenticated')) {
        fetchCartCount();
    }
    // Add to Cart Functionality
    // document.querySelectorAll('.btn-add-to-cart').forEach(button => {
    //     button.addEventListener('click', function() {
    //         const productId = this.getAttribute('data-product-id');
    //         const cartAddUrl = this.getAttribute('data-cart-add-url');
    //         const quantity = document.getElementById('quantity') ? document.getElementById('quantity').value : 1;
    
    //         // NEW: Get selected color & price (if present)
    //         const selectedColorInput = document.getElementById('selectedColor');
    //         const selectedPriceInput = document.getElementById('selectedPrice');
    //         const selectedColor = selectedColorInput ? selectedColorInput.value : null;
    //         const selectedPrice = selectedPriceInput ? selectedPriceInput.value : null;
    
    //         console.log("Sending to Cart:", {
    //             product_id: productId,
    //             quantity: quantity,
    //             selected_color: selectedColor,
    //             selected_price: selectedPrice
    //         });
    
    //         fetch(cartAddUrl, {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //             },
    //             body: JSON.stringify({
    //                 product_id: productId,
    //                 quantity: quantity,
    //                 selected_color: selectedColor,
    //                 selected_price: selectedPrice
    //             })
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             console.log("Response from Server:", data);
    //             if (data.status === 'success') {
    //                 alert('Item added to cart!');
    //                 fetchCartCount(); // Refresh cart count
    //             } else {
    //                 alert('Error: ' + data.message);
    //             }
    //         })
    //         .catch(error => console.error('Error adding item to cart:', error));
    //     });
    // });

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
        console.log('Cart count response:', data); // Add this
        if(data && data.cartCount !== undefined) {
            updateCartCount(data.cartCount);
        } else {
            console.error('Invalid response for cart count:', data);
        }
    })
    .catch(error => console.error('Error fetching cart count:', error));
}




// Update Cart Count in UI
function updateCartCount(count) {
    const cartCountElement = document.getElementById('cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = count;
        localStorage.setItem('cartCount', count);
    } else {
        console.warn('❗ #cart-count element not found in DOM — UI not updated');
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
           
            fetchCartCount(); // Refresh cart count
           
            
         } 
        // else {
        //     alert('Failed to update quantity: ' + data.message);
        // }
        location.reload();
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

            // ✅ Refresh the cart count
            fetchCartCount();

            // ✅ Optionally reload the cart table
            location.reload();
        } else {
            alert('Failed to remove item: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error removing item:', error);
    });
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
            alert('Cart emptied successfully');

            // ✅ Update the cart count in header
            fetchCartCount();

            // ✅ Reload to clear the cart table view
            location.reload();
        } else {
            alert('Failed to empty cart: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error emptying cart:', error);
    });
}
// Checkout Button Redirect
document.addEventListener('DOMContentLoaded', function () {
    const checkoutBtn = document.getElementById('checkout');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            window.location.href = '/checkout';
        });
    }
});

//bulkOrderForm
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('bulkOrderForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const productId = this.getAttribute('data-product-id');
        const userName = this.getAttribute('data-user-name');
        const userEmail = this.getAttribute('data-user-email');
        const userPhone = this.getAttribute('data-user-phone');
        const quantity = document.getElementById('bulkQuantity').value;
        const message = document.getElementById('message').value;

        console.log({ productId, quantity, message, userName, userEmail, userPhone }); // Debug output

        fetch('/bulk-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ quantity, message, productId, userName, userEmail, userPhone })
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok.');
            return response.json();
        })
        .then(data => {
            console.log(data); // Further debug output
            alert(data.message); // Success message
            $('#bulkOrderModal').modal('hide');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    fetchFilters();
    initCollapsibles();

    document.getElementById('sortProducts').addEventListener('change', function() {
        let url = new URL(window.location.href);
        url.searchParams.set('sort', this.value);
        window.location.href = url.href;
    });
});

function fetchFilters() {
    const subCategoryId = document.getElementById('subcategory-id').value;
    fetch(`/filters?subcategory_id=${subCategoryId}`)
        .then(response => response.json())
        .then(data => {
            console.log("✅ Filter data:", data);
            Object.keys(data).forEach(key => {
                const id = `${key.toLowerCase()}-container`;
                populateFilters(data[key], id);
            });
        })
        .catch(error => console.error("❌ Error fetching filters:", error));
}

function populateFilters(items, containerId) {
const container = document.getElementById(containerId);
if (!container) return;

const filterKey = containerId.replace('-container', '');
const urlParams = new URLSearchParams(window.location.search);
const selectedValues = urlParams.getAll(filterKey + '[]');

container.innerHTML = '';
items.forEach(item => {
    const div = document.createElement('div');
    div.className = 'form-check';

    const checkbox = document.createElement('input');
    const value = item.value ?? item.displayName;
    checkbox.type = 'checkbox';
    checkbox.className = 'form-check-input';
    checkbox.name = `${filterKey}[]`;
    checkbox.value = value;
    if (selectedValues.includes(value)) {
        checkbox.checked = true;
    }

    if (selectedValues.includes(item.displayName)) {
        checkbox.checked = true;
    }

    const label = document.createElement('label');
    label.className = 'form-check-label';
    label.appendChild(checkbox);
    label.append(" " + item.displayName);

    div.appendChild(label);
    container.appendChild(div);
});
}

document.getElementById('filter-apply').addEventListener('click', function () {
    const subcategoryId = document.getElementById('subcategory-id').value;
    const baseUrl = `/subcategory/${subcategoryId}`;
    const filters = {};

    // Collect all checked checkboxes
    document.querySelectorAll('#filter-sidebar input[type=checkbox]:checked').forEach(input => {
        const name = input.name; // e.g., "grade[]"
        const value = input.value;

        const key = name.replace('[]', '');
        if (!filters[key]) filters[key] = [];
        filters[key].push(value);
    });

    // Build query string
    const params = new URLSearchParams();
    for (const key in filters) {
        filters[key].forEach(val => params.append(`${key}[]`, val));
    }

    // Redirect with new filter query
    window.location.href = `${baseUrl}?${params.toString()}`;
});


function clearFilters() {
    const url = new URL(window.location.href);
    url.search = '';
    window.location.href = url.href;
}

function initCollapsibles() {
    const collapsibles = document.getElementsByClassName("collapsible");
    for (let i = 0; i < collapsibles.length; i++) {
        collapsibles[i].addEventListener("click", function () {
            this.classList.toggle("active");
            const content = this.nextElementSibling;
            content.style.display = content.style.display === "block" ? "none" : "block";
        });
    }
}




