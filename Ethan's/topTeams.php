<?php
include "query.php";
?>

<?php

if (isset($_POST['rank'])){
    $connection = mysqli_connect('localhost','root', 'root', 'NBA');
    if ($connection){
        echo "<br>";
        echo "Connected!";
    }
    else {
        die ("Lose connection");
        }
    

    $q0 = ranking_query("Teams","wins","1");
    $q1 = topPlayer_game("Golden States", '2018-05-30', "Warriors", "points");
    $q2 = writeSelectQuery('Attends', 'p_name', 'points', '>', 30);
    $q3 = writeAvgQuery('Attends', 'points', 'p_name', 'Steph Curry');
    $q4 = writeAggregateQuery('Attends', 'avg', 'points', 'p_name');
    $q5 = insertQuery('Game_play', '2018-3-22', 'Golden States', 'Warriors', 'Rockets', 100, 98);
    $q6 = deleteQuery('Players', 't_name', 'Rocket');
    $q7 = teamAvgScores();
    $result = mysqli_query($connection, $q7);
    if (!$result){
        echo $q7;
        echo "<br>";
        die('Fail to Query ' . mysqli_error($connection));
        
    }    
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="topTeams.php" method = "post">

<input type="submit"
   name="rank">
    
</form>

   <?php
    
    while ($row = mysqli_fetch_row($result)){
        print_r($row);
        //echo 'here';
        echo "<br>";
    }
    ?>
    
</body>
</html>