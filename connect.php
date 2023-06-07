<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "proiect_php";
    if(!$con = mysqli_connect($dbhost, $dbuser,$dbpass,$dbname)){
    	die("failed to connect");
    }
?>