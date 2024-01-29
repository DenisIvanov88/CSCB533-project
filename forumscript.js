function toggleImageSize(container) {
    const img = container.querySelector('img');
    container.classList.toggle('expanded');
}

function upvoteImage(image_id, button) {
    event.stopPropagation();
    button.classList.toggle('upvoted');
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    };

    var isUpvoted = button.classList.contains('upvoted');

    if (isUpvoted) {
        xmlhttp.open("GET", "upvote.php?image_id=" + image_id, true);
    } else {
        xmlhttp.open("GET", "remove_upvote.php?image_id=" + image_id, true);
    }

    xmlhttp.send();
}

function updateFileName() {
    var fileInput = document.getElementById('image-upload');
    var fileNameDisplay = document.getElementById('file-name-display');

    fileNameDisplay.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : 'No file selected';
}
