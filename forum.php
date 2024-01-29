<?php
session_start();
include("connection.php");
include("functions.php");
$user_data = check_login($con);

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['image'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES['image']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check == false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

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
            $query = "INSERT INTO forum_images (user_id, image_name) VALUES ('$user_id', '$image_name')";
            mysqli_query($con, $query);
            echo "The file " . htmlspecialchars(basename($_FILES['image']['name'])) . " has been uploaded.";
        } else {
           echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="forumstyle.css"/>

    <title>Forum</title>
</head>
<body>
    <script src="forumscript.js"></script>

    <h1>Forum Page</h1>

    <a href="index.php">Back to Home</a>

    <form method="post" enctype="multipart/form-data">
        <label for="image-upload" class="custom-upload-btn">Choose File</label>
        <input type="file" name="image" id="image-upload" accept="image/*" required onchange="updateFileName()">
        <span id="file-name-display">No file selected</span>
        <br><br><input type="submit" value="Upload Image" class="custom-upload-btn">
    </form>

    <?php
        $mostUpvotedImageYesterday = getMostUpvotedImageYesterday($con);

        if ($mostUpvotedImageYesterday) {
            $mostUpvotedImagePath = "uploads/" . $mostUpvotedImageYesterday['image_name'];
            $mostUpvotedUser = getUserName($con, $mostUpvotedImageYesterday['user_id']);

            echo "
                <div class='most-upvoted'>
                <h2>Most Upvoted Image Yesterday</h2>
                <img src='$mostUpvotedImagePath' alt='Most Upvoted Image'>
                <div class='user-box'>$mostUpvotedUser</div>
                <div class='upvote-count'>{$mostUpvotedImageYesterday['votes']}</div>
                </div>
            ";
        }
    ?>

    <div class="gallery">
        <?php
        $query = "SELECT * FROM forum_images ORDER BY uploaded_at DESC";
        $result = mysqli_query($con, $query);


        while ($row = mysqli_fetch_assoc($result)) {
            $image_path = "uploads/" . $row['image_name'];
            $user_name = getUserName($con, $row['user_id']);
            $image_id = $row['image_id'];
            $uploaded_at = date("F j, Y, g:i a", strtotime($row['uploaded_at']));

            $user_has_upvoted = hasUpvoted($con, $user_data['user_id'], $image_id);
            $upvote_class = $user_has_upvoted ? 'upvoted' : 'not-upvoted';

            echo "
                <div class='image-container' onclick='toggleImageSize(this)'>
                    <img src='$image_path' alt='Forum Image'>
                    <div class='user-info'>
                        <div class='user-name'>$user_name</div>
                        <div class='uploaded-at'>$uploaded_at</div>
                    </div>
                    
                    <div class='upvote-container'>
                        <div class='upvote-button $upvote_class' onclick='upvoteImage($image_id, this)'></div>
                        <div class='upvote-count'>{$row['votes']}</div>
                    </div>
                </div>
            ";
        }
        ?>
    </div>
</body>
</html>