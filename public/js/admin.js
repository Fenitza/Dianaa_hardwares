// JavaScript code for handling interactive parts of the dashboard
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('image_preview');
        output.src = reader.result;
        output.style.display = 'block'; // Make the image visible
    };
    reader.readAsDataURL(event.target.files[0]);
}

//delete product from products page
function deleteProduct(productId) {
    if (confirm('This product will be deleted permanently. Are you sure you want to delete this product?')) {
        fetch(`/admin/products/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                alert('Product deleted successfully!');
                window.location.reload(); // or redirect as needed
            } else {
                alert('Error deleting product');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form'); // Adjust if you have more than one form

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Stop the form from submitting immediately

        // Confirm with the user
        if (confirm('Are you sure you want to save these changes?')) {
            form.submit(); // If confirmed, submit the form
        }
    });
});