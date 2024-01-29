<?php
session_start();
include("connection.php");
include("functions.php");
$user_data = check_login($con);

$viewed_user_id = $user_data["user_id"];

$queryPersonalGallery = "SELECT * FROM personal_gallery WHERE user_id = '$viewed_user_id' ORDER BY uploaded_at DESC LIMIT 1";
$resultPersonalGallery = mysqli_query($con, $queryPersonalGallery);
$latestPersonalGalleryImage = mysqli_fetch_assoc($resultPersonalGallery);

$queryForumGallery = "SELECT * FROM forum_images ORDER BY uploaded_at DESC LIMIT 1";
$resultForumGallery = mysqli_query($con, $queryForumGallery);
$latestForumGalleryImage = mysqli_fetch_assoc($resultForumGallery);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="indexstyle.css"/>

    <title>My project</title>
</head>
<body>
    <h1>Index page</h1>

    Hello, <?php echo $user_data['user_name'];?>
    
    <a style="background-image: url('<?php echo "uploads/" . $latestPersonalGalleryImage['image_name']; ?>');" href="personalgallery.php">
        <div class="blurred-background"></div>
        <div class="content">Personal Gallery</div>
    </a>

    <a style="background-image: url('<?php echo "uploads/" . $latestForumGalleryImage['image_name']; ?>');" href="forum.php">
        <div class="blurred-background"></div>
        <div class="content">Forum Gallery</div>
    </a>

    <a id="logout" href="logout.php">Logout</a>
</body>
</html>
