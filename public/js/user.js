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