// Mock Admin Password
const ADMIN_PASSWORD = 'admin'; // In a real application, this should be handled securely on the server.

// Check if we are on the login page
const loginForm = document.getElementById('login-form');
if (loginForm) {
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const password = document.getElementById('password').value;
        if (password === ADMIN_PASSWORD) {
            // Store a session token to indicate the user is logged in
            sessionStorage.setItem('isAdmin', 'true');
            // Redirect to the upload page
            window.location.href = 'upload.html';
        } else {
            alert('Incorrect password.');
        }
    });
}

// Check if we are on the upload page and if the user is an admin
const uploadForm = document.getElementById('upload-form');
if (uploadForm) {
    // Protect the page
    if (sessionStorage.getItem('isAdmin') !== 'true') {
        // If not logged in, redirect to the login page
        window.location.href = 'admin.html';
    }

    uploadForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        // In a real application, you would handle the file uploads and form data here.
        // For this example, we'll just log the data to the console.
        
        const thumbnail = document.getElementById('thumbnail').files[0];
        const photos = document.getElementById('photos').files;
        const description = document.getElementById('description').value;
        const startDate = document.getElementById('start-date').value;
        const finishDate = document.getElementById('finish-date').value;

        console.log('Project Thumbnail:', thumbnail);
        console.log('Project Photos:', photos);
        console.log('Project Description:', description);
        console.log('Start Date:', startDate);
        console.log('Finish Date:', finishDate);

        alert('Project uploaded successfully! (Check the console for data)');
        
        // Clear the form
        uploadForm.reset();
    });
}
