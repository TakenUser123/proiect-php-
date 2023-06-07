<?php
session_start();

include("connect.php");
include("fct.php");
$user_data = check_login($con);
if (!$user_data) {
    echo "Error: Unauthorized access. Please log in.";
    exit;
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Index</title>
  
	<link href="style.css" rel="stylesheet" type="text/css" media="all">
	<link href="index2.css" rel="stylesheet" type="text/css" media="all">
</head>
<body>
<button onclick="location.href='logout.php'" class="logout-btn">Logout</button>

	<h1><a href = "home.php">Pagina Principala</h1></a>

</body>
</html>
