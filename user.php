<?php include "player.php"; ?>
<?PHP include "query.php"; ?>
<?php include "connection.php"; ?>
<?php
session_start();
$query = $_SESSION['query'];
class User {
    private $userID;
    private $password;
    private $isAdmin;
    
    
    function __construct($username, $password, $isAdmin) {
        $this -> userName = $username;
        $this -> password = $password;
        $this -> isAdmin = $isAdmin;
    }
    
    public function getFavoritePlayer() {
        $playerName = $this -> getPlayerName();
        $player = $this -> getPlayer($playerName);
        return $player;
    }
    
    public function updateFavoritePlayer($playerName) {
        
    }
    
    private function getPlayerName() {
        global $query;
        global $connection;
        $selectQuery = $query -> writeSelectQuery("Favorite", "player_name", "userID", "=", $this->userID, NULL);
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $playerName = $row['player_name'];
        return $playerName;
    }
    
    private function getPlayer($playerName) {
        global $query;
        global $connection;
        $selectQuery = $query -> writeSelectQuery("PlayerHas", "*", "name", "=", $playerName, NULL);
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $age = $row['age'];
        $jerseyNum = $row['jersey_num'];
        $nationality = $row['nationality'];
        $player = new Player($playerName, $age, $nationality, $jerseyNum);
        return $player;
    }
    
    
}




?>