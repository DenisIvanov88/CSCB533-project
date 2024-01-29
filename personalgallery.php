<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);

$viewed_user = isset($_GET['user']) ? $_GET['user'] : $user_data['user_name'];

$query = "SELECT user_id FROM users WHERE user_name = '$viewed_user'";
$result = mysqli_query($con, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: index.php");
    exit();
}

$viewed_user_id = mysqli_fetch_assoc($result)['user_id'];

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['image'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES['image']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "webp") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_name = basename($_FILES['image']['name']);
            $user_id = $user_data['user_id'];
            $query = "INSERT INTO personal_gallery (user_id, image_name) VALUES ('$user_id', '$image_name')";
            mysqli_query($con, $query);
            echo "The file " . htmlspecialchars(basename($_FILES['image']['name'])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$query = "SELECT * FROM personal_gallery WHERE user_id = '$viewed_user_id'";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="personalgallerystyle.css"/>

    <title>Personal Gallery</title>
</head>
<body>
    <script src="personalgalleryscript.js"></script>

    <h1>Personal Gallery</h1>

    <a href="index.php">Back to Home</a>

    <form method="post" enctype="multipart/form-data">
        <label for="image-upload" class="custom-upload-btn">Choose File</label>
        <input type="file" name="image" id="image-upload" accept="image/*" required onchange="updateFileName()">
        <span id="file-name-display">No file selected</span>
        <br><input type="submit" value="Upload Image" class="custom-upload-btn">
    </form>

    <div class="gallery">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $image_path = "uploads/" . $row['image_name'];
            echo "
                <div class='image-container' onclick='toggleImageSize(this)'>
                    <img src='$image_path' alt='Forum Image'>
                </div>
                ";
        }
        ?>
    </div>
</body>
</html>