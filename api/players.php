<?php include "../database/connection.php" ?>

<?php

# ENDPOINTS

# GET /api/players.php
# GET /api/players.php?username=...
# GET /api/players.php?team=...
# GET /api/players.php?stats=true

$username = $_GET['username'];
$team = $_GET['team'];
$stats = $_GET['stats'];

$query = "SELECT * FROM PLAYERHAS, CAREER WHERE PLAYER_NAME = PLAYERHAS.NAME";

if ($username) {
        $query = "SELECT * FROM PLAYERHAS, CAREER, USER_LIKEPLAYER 
    WHERE PLAYERHAS.NAME = CAREER.PLAYER_NAME AND PLAYERHAS.NAME = USER_LIKEPLAYER.PLAYER_NAME 
    AND USER_LIKEPLAYER.USERID = '$username'";
}

$query .= ($team ? " AND PLAYERHAS.teamName = '$team'" : '');

if ($stats && $stats == "true") {
    $query = "
    SELECT 
      PLAYER_NAME as name, 
      AVG(POINTS) as points, 
      AVG(REBOUNDS) as rebounds, 
      AVG(ASSISTS) as assists, 
      AVG(BLOCKS) as blocks, 
      AVG(STEALS) as steals 
    FROM ATTENDS
    GROUP BY ATTENDS.PLAYER_NAME";
}

$array = array();
if ($result = mysqli_query($connection,$query)) {

    while($row = mysqli_fetch_assoc($result)) {
        $array[] = $row;
    }
}

echo json_encode($array);

?>