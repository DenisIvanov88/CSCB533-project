<?php
session_start();
include("connection.php");

if(isset($_GET['image_id']) && isset($_SESSION['user_id'])) {
    $image_id = $_GET['image_id'];
    $user_id = $_SESSION['user_id'];

    $check_query = "SELECT * FROM user_votes WHERE user_id = '$user_id' AND image_id = '$image_id'";
    $check_result = mysqli_query($con, $check_query);

    if(mysqli_num_rows($check_result) == 0) {
        $update_query = "UPDATE forum_images SET votes = votes + 1 WHERE image_id = '$image_id'";
        mysqli_query($con, $update_query);

        $insert_query = "INSERT INTO user_votes (user_id, image_id) VALUES ('$user_id', '$image_id')";
        mysqli_query($con, $insert_query);

        echo "Upvote successful";
    } else {
        echo "User has already upvoted this image";
    }
} else {
    echo "Invalid request";
}
