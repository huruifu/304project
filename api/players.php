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

$query = "SELECT * FROM PLAYERHAS
          INNER JOIN CAREER C2 ON PLAYERHAS.NAME = C2.PLAYER_NAME";

if ($username) {
    $query= "SELECT * FROM PLAYERHAS
            INNER JOIN CAREER C2 ON PLAYERHAS.NAME = C2.PLAYER_NAME
            INNER JOIN USER_LIKEPLAYER L2 ON PLAYERHAS.NAME = L2.PLAYER_NAME AND L2.USERID = '$username'";
}

$query .= ($team ? " WHERE PLAYERHAS.teamName = '$team'" : '');

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