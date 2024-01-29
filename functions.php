<?php

function check_login($con) {
    if(isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query = "select * from users where user_id = '$id' limit 1";

        $result = mysqli_query($con, $query);
        if(mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }

    //redirect to login
    header("Location: login.php");
    die;
}

function random_num($length){
    $text = "";
    if($length < 5){
        $length = 5;
    }

    $len = rand(4, $length);

    for($i = 0; $i < $len; $i++){
        $text .= rand(0, 9);
    }

    return $text;
}

function getUserName($con, $user_id) {
    $query = "SELECT user_name FROM users WHERE user_id = '$user_id' LIMIT 1";
    $result = mysqli_query($con, $query);

    if(mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        return $user_data["user_name"];
    }
}

function hasUpvoted($con, $user_id, $image_id) {
    $query = "SELECT * FROM user_votes WHERE user_id = '$user_id' AND image_id = '$image_id'";
    $result = mysqli_query($con, $query);
    return mysqli_num_rows($result) > 0;
}

function getMostUpvotedImageYesterday($con) {
    $yesterday = date('Y-m-d', strtotime('yesterday'));

    $query = "SELECT * FROM forum_images WHERE DATE(uploaded_at) = '$yesterday' ORDER BY votes DESC LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    }

    return null;
}