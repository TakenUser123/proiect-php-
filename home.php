<?php
   session_start();

   include("connect.php");
   include("fct.php");
   $user_data=check_login($con);
   if(!$user_data){
      echo "Error: Unauthorized access. Please log in.";
      exit;
   }
?>


<!DOCTYPE html>
<html lang="en">
   <head>
      <title >Home</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="home.css" rel="stylesheet" type="text/css" media="all">
      <link href="style.css" rel="stylesheet" type="text/css" media="all">
   </head>
   <body>
      <div class="backdrop type1">
         <h1 class="button" ><a href="index2.php">Liga Romaniei</a></h1>
            <nav>
               <ul>
                 <li><a href="upcoming_games.php">Urmatoarele Meciuri</a></li>
                 <li><a href="export_upcoming_games.php">Export To CSV</a></li>
                 <li><a href="fav_games.php">Meciurile Echipei Tale</a></li>
                 <li><a href="rankings.php">Clasament</a></li>
               </ul>
            </nav>
      </div>
   </body>
</html>