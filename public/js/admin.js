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
document.addEventListener('DOMContentLoaded', function() {
    var fileInput = document.getElementById('image_path');
    var fileDisplayArea = document.getElementById('file-name-display');
    var previewContainer = document.getElementById('image-preview-container'); // Ensure this div exists in your HTML

    fileInput.addEventListener('change', function(event) {
        var files = event.target.files;
        var fileNames = [];

        previewContainer.innerHTML = ''; // Clear existing previews

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            fileNames.push(file.name); // Add file name to the list

            // Check if the file is an image.
            if (file.type.startsWith('image/')) {
                var img = document.createElement('img');
                img.classList.add('img-preview');
                img.style.width = '100px'; // Set image preview size
                img.style.height = '100px'; // Set image preview size
                img.style.objectFit = 'cover'; // Set how the image should be resized to fit the container
                img.style.marginRight = '10px'; // Add some space between images

                previewContainer.appendChild(img); // Add the image to the container

                var reader = new FileReader();
                reader.onload = (function(aImg) {
                    return function(e) { aImg.src = e.target.result; };
                })(img);
                reader.readAsDataURL(file);
            }
        }

        // Display all filenames
        fileDisplayArea.textContent = fileNames.join(', ');
    });
});
