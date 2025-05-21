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
    
document.addEventListener('DOMContentLoaded', function() {
function previewMultipleImages(event) {
    var files = event.target.files;
    var container = document.getElementById('image_preview_container');
    container.innerHTML = ''; // Clear existing previews

    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        if (file.type.startsWith('image/')) {
            var img = document.createElement('img');
            img.classList.add("img-preview");
            img.file = file;

            container.appendChild(img); // Assume "preview" is the id of the div where you want to display the image

            var reader = new FileReader();
            reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
            reader.readAsDataURL(file);
        }
    }
}
});


// file name display
document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('image_path');
        const fileDisplayArea = document.getElementById('file-name-display');
        const previewContainer = document.getElementById('image-preview-container');

        fileInput.addEventListener('change', function (event) {
            const files = event.target.files;
            let fileNames = [];

            previewContainer.innerHTML = ''; // Clear existing previews

            Array.from(files).forEach(file => {
                fileNames.push(file.name);

                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.classList.add('img-preview');

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);

                    previewContainer.appendChild(img);
                }
            });

            // Display filenames
            fileDisplayArea.innerHTML = `<strong>Selected:</strong> ${fileNames.join(', ')}`;
        });
    });