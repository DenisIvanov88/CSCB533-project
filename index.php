<?php
session_start();
include("connection.php");
include("functions.php");
$user_data = check_login($con);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My project</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            color: #333;
        }

        a {
            text-decoration: none;
            color: #2196F3;
            margin: 10px 0;
            font-size: 18px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    Hello, <?php echo $user_data['user_name'];?>

    <h1>Index page</h1>
    
    <a href="personalgallery.php">Personal Gallery</a>

    <a href="forum.php">Forum Gallery</a>

    <a href="logout.php">Logout</a>
</body>
</html>