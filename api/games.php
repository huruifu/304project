<?php include "../database/connection.php" ?>
<?php

# ENDPOINTS

# GET /api/games.php

$query = "SELECT TEAM1 as homeTeam,
          TEAM2 as awayTeam,
          GAME_TIME as time,
          GAME_LOCATION as location,
          TEAM1_SCORE as homeTeamPoints,
          TEAM2_SCORE as awayTeamPoints
          FROM GAMEPLAY";

$array = array();
if ($result = mysqli_query($connection,$query)) {

    while($row = mysqli_fetch_assoc($result)) {
        $array[] = $row;
    }
}

echo json_encode($array);

?>