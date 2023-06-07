<?php
    session_start();
    include("connect.php");
    include("fct.php");

    $user_data = check_login($con);
    if (!$user_data) {
        echo "Error: Unauthorized access. Please log in.";
        exit;
    }
    
    $favorite_team = $user_data['favorite_team'];

    // Numele echipelor cu care joaca echipa favorita
    $current_date = date('Y-m-d');
    $query = "SELECT g.*, t1.name AS home_team_name, t2.name AS away_team_name
              FROM games g
              INNER JOIN teams t1 ON g.home_team_id = t1.id
              INNER JOIN teams t2 ON g.away_team_id = t2.id
              WHERE (g.home_team_id = '$favorite_team' OR g.away_team_id = '$favorite_team')
              AND g.date < '$current_date'
              ORDER BY g.date DESC";
    $result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Meciurile echipei favorite</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="fav_games.css">
    </head>
    <body>
        <h1>Meciurile echipei favorite</h1>    
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table>
                <tr>
                    <th>Data</th>
                    <th>Echipa gazda</th>
                    <th>Echipa vizitatoare</th>
                    <th>Scor</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['home_team_name']; ?></td>
                        <td><?php echo $row['away_team_name']; ?></td>
                        <td><?php echo $row['home_team_score'] . ' - ' . $row['away_team_score']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>Nu exista meciuri</p>
        <?php } ?>

        <a href="home.php">Pagina Principala</a>
        <a href="logout.php">Logout</a>
    </body>
</html>