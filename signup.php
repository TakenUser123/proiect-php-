<?php
session_start();
ob_start();
include("connect.php");
include("fct.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Verify reCAPTCHA response
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptchaSecretKey = '6LdUc3YmAAAAAIBGFm35f5pBMJHhF5Vnu8ySMkb0'; // Replace with your reCAPTCHA secret key

    $recaptchaData = [
        'secret' => $recaptchaSecretKey,
        'response' => $recaptchaResponse,
    ];

    $recaptchaOptions = [
        'http' => [
            'method' => 'POST',
            'content' => http_build_query($recaptchaData),
            'header' => 'Content-Type: application/x-www-form-urlencoded',
        ],
    ];

    $recaptchaContext = stream_context_create($recaptchaOptions);
    $recaptchaResult = file_get_contents($recaptchaUrl, false, $recaptchaContext);
    $recaptchaResult = json_decode($recaptchaResult, true);

    if ($recaptchaResult['success'] && $recaptchaResult['score'] >= 0.5) {
        // reCAPTCHA verification successful
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
    } else {
        // reCAPTCHA verification failed
        echo "reCAPTCHA verification failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <link href="signup.css" rel="stylesheet" type="text/css" media="all">
      <link href="style.css" rel="stylesheet" type="text/css" media="all">
    <!-- <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('YOUR_RECAPTCHA_SITE_KEY', { action: 'signup' }).then(function (token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
            });
        });
    </script> -->
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

    <!-- Add reCAPTCHA widget -->
    <div class="g-recaptcha" style="height: 100px; height: 100px;" data-sitekey="6LdUc3YmAAAAAO42JKBqSofJqDh2tFHvbJUYTIAm" data-callback="onSubmit"></div>

    <input id="submit" type="submit" value="Submit">
    <button type="button" onclick="location.href='index.php'" id="login-btn">Login</button>
</form>


    </div>
</body>
</html>
