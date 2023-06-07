<?php
session_start();
ob_start();
include("connect.php");
include("fct.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $fav_team = $_POST['favorite_team'];

    if (!empty($username) && !empty($password) && !is_numeric($username)) {
        // Save to database
        $query = "INSERT INTO users (username, `password`, `name`, email, favorite_team) 
                  VALUES ('$username', '$password', '$name', '$email', '$fav_team')";
        mysqli_query($con, $query);

        header("Location: index.php");
        exit;
    } else {
        echo "Please enter valid information!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link href="signup.css" rel="stylesheet" type="text/css" media="all">
    <link href="style.css" rel="stylesheet" type="text/css" media="all">
</head>
<body>
    <div id="box">
        <form method="post" id="signup-form">
            <div style="font-size:20px;margin:10px">Signup</div>
            <label for="username">Username:</label>
            <input id="text" type="text" name="username">

            <label for="password">Password:</label>
            <input id="text" type="password" name="password">

            <label for="name">Name:</label>
            <input id="text" type="text" name="name">

            <label for="email">Email:</label>
            <input id="text" type="text" name="email">

            <label for="favorite_team">Favorite Team:</label>
            <input id="number" type="text" name="favorite_team">

            <input id="submit" type="submit" value="Submit">
            <button type="button" onclick="location.href='index.php'" id="login-btn">Login</button>
        </form>
    </div>
</body>
</html>
