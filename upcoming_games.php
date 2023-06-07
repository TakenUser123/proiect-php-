<?php
session_start();

include("connect.php");
include("fct.php");

$user_data = check_login($con);
if (!$user_data) {
    echo "Error: Unauthorized access. Please log in.";
    exit;
}

$currentDate = date('Y-m-d');
$query = "SELECT * FROM games WHERE date > '$currentDate' ORDER BY date ASC";
$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Urmatoarele meciuri</title>
    
    <link href="upcoming_games.css" rel="stylesheet" type="text/css" media="all">
      <link href="style.css" rel="stylesheet" type="text/css" media="all">
</head>
<body>
    <h1>Urmatoarele meciuri</h1>

    <?php
    // Check if there are any upcoming games
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $gameId = $row['id'];
            $date = $row['date'];
            $homeTeamId = $row['home_team_id'];
            $awayTeamId = $row['away_team_id'];

            // Retrieve home team and away team details
            $homeTeamQuery = "SELECT * FROM teams WHERE id = $homeTeamId";
            $homeTeamResult = mysqli_query($con, $homeTeamQuery);
            $homeTeam = mysqli_fetch_assoc($homeTeamResult);

            $awayTeamQuery = "SELECT * FROM teams WHERE id = $awayTeamId";
            $awayTeamResult = mysqli_query($con, $awayTeamQuery);
            $awayTeam = mysqli_fetch_assoc($awayTeamResult);

            // Display game information
            echo "<p>";
            echo "Data: $date<br>";
            echo "Echipa gazda: " . $homeTeam['name'] . "<br>";
            echo "Echipa vizitatoare: " . $awayTeam['name'];
            echo "</p>";
        }
    } else {
        echo "Nu urmeaza niciun meci.";
    }
    ?>
    
    <a href="home.php">Pagina Principala</a>
    <a href="logout.php">Logout</a>
    
</body>
</html>
