function toggleImageSize(container) {
    const img = container.querySelector('img');
    container.classList.toggle('expanded');
}

function updateFileName() {
    var fileInput = document.getElementById('image-upload');
    var fileNameDisplay = document.getElementById('file-name-display');

    fileNameDisplay.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : 'No file selected';
}