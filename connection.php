<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "password";
$dbname = "cscb688_project_database";

if(!$con = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname)) {
    die("failed to connect". mysqli_connect_error());
}
