<?php include "../database/connection.php" ?>
<?php

# ENDPOINTS

# GET /api/teams.php
# GET /api/teams.php?username=...
# GET /api/teams.php?topn=...&order=asc|desc&stat=win|loss

$username = $_GET['username'];
$topn = $_GET['topn'];
$order = $_GET['order'];
$stat = $_GET['stat'];

$query = "SELECT * FROM TEAM";

if ($username) {
    $query = "
    SELECT * FROM TEAM
    INNER JOIN USER_LIKETEAM L2 ON TEAM.NAME = L2.TEAM_NAME AND L2.USERID = '$username'
    ";
} else if ($topn) {

    if ($order && $order == "asc") {
        $order = "ASC";
    } else {
        $order = "DESC";
    }

    if ($stat == "loss") {
        $query = "
    SELECT * FROM TEAM
    ORDER BY TEAM.NUM_LOSS $order
    LIMIT $topn
    ";
    } else {
        $query = "
    SELECT * FROM TEAM
    ORDER BY TEAM.NUM_WIN $order
    LIMIT $topn
    ";
    }
}

$array = array();
if ($result = mysqli_query($connection,$query)) {

    while($row = mysqli_fetch_assoc($result)) {
        $array[] = $row;
    }
}

echo json_encode($array);

?>
