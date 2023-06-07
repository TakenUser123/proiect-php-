<?php
session_start();
include("connect.php");
include("fct.php");


$user_data = check_login($con);
if (!$user_data) {
    echo "Error: Unauthorized access. Please log in.";
    exit;
}

$query = "SELECT * FROM leagues";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Clasamente</title>
    <link href="rankings.css" rel="stylesheet" type="text/css" media="all">
    <link href="style.css" rel="stylesheet" type="text/css" media="all">
</head>
<body>
    <h1>Clasamente</h1>

    <?php while ($league = mysqli_fetch_assoc($result)) { ?>
        <h2><?php echo $league['name']; ?></h2>

        <?php
        $league_id = $league['id'];
        // Retrieve teams for the current league sorted by points
        $query = "SELECT *, ROW_NUMBER() OVER (ORDER BY points DESC) AS rank FROM teams WHERE league_id = '$league_id' ORDER BY points DESC";
        $teams_result = mysqli_query($con, $query);
        ?>

        <?php if (mysqli_num_rows($teams_result) > 0) { ?>
            <table>
                <tr>
                    <th>#</th>
                    <th>Echipa</th>
                    <th>Puncte</th>
                </tr>
                <?php while ($team = mysqli_fetch_assoc($teams_result)) { ?>
                    <tr>
                        <td><?php echo $team['rank']; ?></td>
                        <td><?php echo $team['name']; ?></td>
                        <td><?php echo $team['points']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>Nu exista nicio echipa</p>
        <?php } ?>
    <?php } ?>

    <a href="home.php">Pagina Principala</a>
    <a href="logout.php">Logout</a>
</body>
</html>