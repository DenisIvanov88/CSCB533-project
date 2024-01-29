<?php
session_start();
include("connection.php");

if(isset($_GET['image_id']) && isset($_SESSION['user_id'])) {
    $image_id = $_GET['image_id'];
    $user_id = $_SESSION['user_id'];

    $delete_query = "DELETE FROM user_votes WHERE user_id = '$user_id' AND image_id = '$image_id'";
    mysqli_query($con, $delete_query);

    $update_query = "UPDATE forum_images SET votes = votes - 1 WHERE image_id = '$image_id'";
    mysqli_query($con, $update_query);

    echo "Upvote removed";
} else {
    echo "Invalid request";
}
