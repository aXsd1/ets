// Handle the upload form submission and display a simple alert for demo
const uploadForm = document.getElementById('upload-form');
if (uploadForm) {
    uploadForm.addEventListener('submit', function(event) {
        // No longer prevent default; allow native form submission to backend
        // event.preventDefault();
        // No need to handle logic here – PHP will process the submission
    }); 
}
