<?php
// Start the session
session_start();

// If the user is already logged in, then redirect to website
if (!empty($_SESSION["username"])) {
    header("location: index.php");
    die();
}

// If parameters username and password not properly set, redirect to home page
if (!empty($_POST['username']) && !empty($_POST['password'])) {

    // A separate file to hide login details
    include './connection.php';

    // username and password sent from form
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    $query = "SELECT username 
            FROM ea_Admin 
            WHERE username = '$username' and password = '$password';";

    // Run Select SQL query
    $results = $conn->query($query);

    $count = $results->num_rows;

    // Close connection after executing the query
    $conn->close();

    // If result matched given username and password, there must be 1 row
    if ($count == 1) {
        $_SESSION["username"] = $username;

        header("location: index.php");
        die();
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dream Home</title>
    <link rel="icon" type="image/png" href="./images/DreamHomeFavicon.png"/>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <link rel="stylesheet" type="text/css" href="styles/styles.css"/>
</head>
<body class="login">
    <form class="login_form" action="login.php" method="POST">
        <label for="username">Username:</label><br/>
        <input type="text" name="username" required/><br/><br/>
        <label for="password">Password:</label><br/>
        <input type="password" name="password" required/><br/><br/>
        <?php
        if (!empty($error)) {
            ?>
            <p id="login_form_error"><?php echo $error ?></p><br>
            <?php
        }
        ?>
        <input type="submit" value="Login"/>
    </form>
</body>
</html>