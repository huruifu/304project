<?php
session_start();

$username = $_SESSION['username'];
if (!$username) {
    echo "<script>window.location='/webpage/login.php'</script>";
}

// use this to find favourite teams/players
echo "
    <div class='footer' style='position: fixed; left: 0; bottom: 0;'>
        Username: <p id='username'>$username</p>
        Password: <input id='password' type='password'>
        <button onclick='updatePassword()'>Update Password</button>
        <button onclick='deleteAccount()'>Delete Account</button>
    </div>
"
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LoginPage</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src='queryHandler.js'></script>
    <script src='admin.js'></script>
</head>
<body>
<div id='header'>
    <h1 style="color: white; align-self: baseline">NBA DATABASE</h1>
</div>
<br>
<div id='buttonGroup'>
    <button class="btn" type="button" name="team" onclick="onSelectTab(name)">Team</button>
    <button class="btn" type="button" name="player" onclick="onSelectTab(name)">Player</button>
    <button class="btn" type="button" name="game"onclick="onSelectTab(name)">Game</button>
</div>
<div id='team' class='tabContent'>
    <div class="query" id="team_q1">
        Rank Top
        <input type="text" name="param1" placeholder="e.g. 10">
        Winning Teams
        <button inline type="submit" onclick="handleQuery('team_q1')">Query!</button>
    </div>
    <div class="query" id="team_q2">
        Show teams that have competed with
        <input type="text" name="param1" placeholder="Team Name">
        <button inline type="submit" onclick="handleQuery('team_q2')">Query!</button>
    </div>
    <div class="query" id="team_q3" >
        Show teams that have played at
        <input type="text" name="param1" placeholder="City">
        <button inline type="submit" onclick="handleQuery('team_q3')">Query!</button>
    </div>
    <div id="team_result"></div>
</div>
<div id='player' class="tabContent">
    <div class="query" id="player_q1"></div>
    <div class="query" id="player_q2"></div>
    <div class="query" id="player_q3" ></div>
    <div id="player_result"></div>
</div>
<div id='game' class="tabContent">
    <div class="query" id="game_q1">
        Filter by team:
        <input type="text" placeholder="Enter Team">
        <button inline type="submit" onclick="handleQuery('game_q1')">Query!</button>
    </div>
    <div class="query" id="game_q2">

    </div>
    <div class="query" id="game_q3"></div>
    <div id="game_result"></div>
</div>
</body>
</html>
