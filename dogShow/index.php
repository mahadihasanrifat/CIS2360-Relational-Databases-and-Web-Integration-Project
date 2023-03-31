<?php
session_start();

// If the user is not logged in, then redirect to login page
if(empty($_SESSION["username"])){
    echo $_SESSION["username"];
    header("location: login.php");
    die();
}

// separate file for uniform header
include './header.php';
// separate file for uniform left column
include './leftcolumn.php';
// separate file for uniform right column
include './rightcolumn.php';
// separate file for uniform footer
include './footer.php';
?>
