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

    $data_upcoming_games = array();
    $data_upcoming_games[] = array('Data', 'Echipa Gazda', 'Echipa Vizitatoare');

    // Verif daca urmeaza meciuri
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $gameId = $row['id'];
            $date = $row['date'];
            $homeTeamId = $row['home_team_id'];
            $awayTeamId = $row['away_team_id'];

            $homeTeamQuery = "SELECT * FROM teams WHERE id = $homeTeamId";
            $homeTeamResult = mysqli_query($con, $homeTeamQuery);
            $homeTeam = mysqli_fetch_assoc($homeTeamResult);

            $awayTeamQuery = "SELECT * FROM teams WHERE id = $awayTeamId";
            $awayTeamResult = mysqli_query($con, $awayTeamQuery);
            $awayTeam = mysqli_fetch_assoc($awayTeamResult);

            $data_upcoming_games[] = array($date, $homeTeam['name'], $awayTeam['name']);
        }
    }

    // Export to CSV
    exportToCSV('upcoming_games_data', $data_upcoming_games);
?>