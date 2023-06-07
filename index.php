<?php
session_start();
include("connect.php");
include("fct.php");


if($_SERVER['REQUEST_METHOD']=="POST"){
	
	$username=mysqli_real_escape_string($con,$_POST['username']);

	$password=mysqli_real_escape_string($con,$_POST['password']);
	if(!empty($username)&&!empty($password)&&!is_numeric($username)){
	
		$query="select * from users where username='$username' limit 1";
		$result=mysqli_query($con,$query);
		if($result){
			if($result&&mysqli_num_rows($result)>0){
				$user_data = mysqli_fetch_assoc($result);
				
				if($user_data['password'] === $password){
		
		      $_SESSION['id']=$user_data['id'];
		       header("Location: index2.php");
		       exit;
	       }
        }
 }
		echo '<span">Parola sau username gresite!</span>';

}}

?>

<!DOCTYPE html>
<head>
	<title>Login</title>
	<link href="style.css" rel="stylesheet" type="text/css" media="all">
	<link href="login.css" rel="stylesheet" type="text/css" media="all">
</head>
<body>


<div id="box">
   <form method="post">
      <h2>Login</h2>
      <label>Username:</label>
      <input id="text" type="text" name="username">
      <label>Parola:</label>
      <input id="text" type="password" name="password">
      <input id="button" type="submit" value="Login">
      <button id="button" type="button"><a href="signup.php">Inregistrare</a></button>
   </form>
</div>
</body>

