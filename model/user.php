<?php include "player.php"; ?>
<?PHP include "query.php"; ?>
<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/databse/header.php";
include $path ;
?>

<?php

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
    
    // Teams Query:
    
    //Selecting the top X teams in a season based on the number of winning games.
    public function getTopTeam($orderBy, $topNum) {
        global $query;
        global $connection;
        $teams = array();
        $queryL = $query -> ranking_query("Teams", $orderBy, $topNum);
        $result = mysqli_query($connection, $queryL);
        if (!$result) {
            die("FAILED TO OPERATE" . mysqli_error($connection));
        }
        return $result;
    }
    
    
    //Searching for all games related to the user-selected team.
    public function getAllGamesParticipated($teamName) {
        $selectQuery = "SELECT * ";
        $selectQuery .= "FROM Gameplay ";
        $selectQuery .= "WHERE t_name1 = '$teamName' OR t_name2 = '$teamName' ";
        $result = mysqli_query($connection, $selectQuery);
        if (!$result) {
            die("FAILED TO OPERATE" . mysqli_error($connection));
        }
        return $result;
    }
    
    
    //Given specific location and time, returning teams played at that location or time.
    public function selectSpecificGame($time, $location) {
        global $query;
        global $connection;
        $selectQuery = "SELECT * FROM Game_play WHERE g_time= '$time' AND g_location = $location ";
        $result = mysqli_query($connection, $selectQuery);
        if (!$result) {
            die("FAILED TO OPERATE" . mysqli_error($connection));
        }
        return $result;
    }
    

   
    //Games Query
    
    // get players who get the most record in a given game.
    public function getTopPlayerInGame($g_location, $g_time, $team, $record) {
        $selectQuery = $query -> topPlayer_game($g_location, $g_time, $team, $record);
        $result = mysqli_query($connection, $selectQuery);
        if (!$result) {
            die("FAILED TO OPERATE" . mysqli_error($connection));
        }
        return $result;
    }
    

    
 
    
    
    
    // Player's Query
    
    //Calculating one player’s average statistics per game (points, rebounds, steals, assists, or blocks).
    // $aggregateColumn is the type of record.
    public function getAverageX($playerName, $aggregateColumn) {
        $averageQuery = $query -> writeAggregateQuery("Attends", "AVG", $aggregateColumn, "p_name");
        $averageQuery .= "HAVING p_name = '$playerName' ";
        $result = mysqli_query($connection, $averageQuery);
        return $result;
    }
    
    public function getAllPlayerAverageX($aggregateColumn) {
        $averageQuery = $query -> writeAggregateQuery("ATTENDS", "AVG", $aggregateColumn, "p_name");
        $result = mysqli_query($connection, $averageQuery);
        if (!$result) {
            die("OPERATE FAILED " . mysqli_error($connection));
        }
        return $result;
    }
    
    // get the minimum or maximum among all average.
    // $aggregate is MAX or MIN
    public function getMaxOrMinAvgX($aggregateColumn, $aggregate) {
        $avgQuery = "SELECT p_name AS name, AVG($aggregateColumn) AS info ";
        $avgQuery .= "FROM ATTENDS ";
        $avgQuery .= "GROUP BY p_name ";
        
        $aggQuery = "SELECT t1.name, $aggregate(info) ";
        $aggQuery .= "FROM ($avgQuery) AS t1 ";
        $result = mysqli_query($connection, $aggQuery);
        if (!$result) {
            die("OPERATE FAILED " . mysqli_error($connection));
        }
        return $result;
        
    }
    
    
    
    
    //Presenting players whose specific statistics in one game (points, rebounds, steals, assists, or blocks) are greater or less than one specific number that users input.
    public function getPlayersMeetRequirment($typeOfRecord, $operator, $value) {
        $selectQuery = $query -> writeSelectQuery('Attends', 'p_name', $typeOfRecord, $operator, $value);
        $result = mysqli_query($connection, $selectQuery);
        if (!$result) {
            die("FAILED OPERATE" . mysqli_error($connection));
        }
        return $result;
    }
    
    
    //Selecting the top X players in a season based on number of MVP, All-Star
    //requirement is MVP or ALL-STAR
    public function getTopXCareer($num, $requirement) {
        $selectQuery = $query -> ranking_query('Career', $requirement, $num);
        $result = mysqli_query($connection, $selectQuery);
        if (!$result) {
            die("FAILED OPERATE" . mysqli_error($connection));
        }
        return $results;
    }
    
    
    //Selecting the top X players in a season based on number of average points, rebounds, steals, assists, or blocks per game.
    public function getTopAvgStat($num, $orderBy) {
        $averageQuery = "SELECT p_name, AVG($orderBy) AS ord ";
        $averageQuery .= "FROM Attends ";
        $averageQuery .= "GROUP BY p_name";
        $rankQuery = "SELECT q1.p_name ";
        $rankQuery .= "FROM ($averageQuery) AS q1 ";
        $rankQuery .= "ORDER BY q1.ord ";
        $rankQuery .= "LIMIT $num ";
        $result = mysqli_query($connection, $rankQuery);
        if (!$result) {
            die("FAILED OPERATE" . mysqli_error($connection));
        }
        return result;
    }
    
    
    // Given specific score, rebound, assist, steal and block, choose all players whose average scores, rebounds, assists, steals and blocks is greater than the values respectively.

    public function getPlayerMeetAvgRequirement($typeOfRecord, $operator, $value) {
        $averageQuery = "SELECT p_name, AVG($typeOfRecord) AS ord ";
        $averageQuery .= "FROM Attends ";
        $averageQuery .= "GROUP BY p_name";
        $rankQuery = "SELECT q1.p_name ";
        $rankQuery .= "FROM ($averageQuery) AS q1 ";
        $rankQuery .= "WHERE q1.ord $operator $value ";
        $result = mysqli_query($connection, $rankQuery);
        if (!$result) {
            die("FAILED OPERATE" . mysqli_error($connection));
        }
        return $result;
    }
    
    
  //-----------------------------------------------------  
    
    
    
    
    
    public function setFavoritePlayer($playerName) {
        $updateQuery = $query -> updateQuery("", "", "", "", $playerName);
        $result = mysqli_error($connection, $updateQuery);
        if (!$result) {
            die("OPERATOR FAILED " . mysqli_error($connection));
        }
        return $result;
    }
    
    
    
    
    private function getPlayerName() {
        global $query;
        global $connection;
        $selectQuery = $query -> writeSelectQuery("Favorite", "player_name", "userID", "=", $this->userID);
        $result = mysqli_query($connection, $query);
        if (!$result) {
            die("FAILED TO OPERATE" . mysqli_error($connection));
        }
        $row = mysqli_fetch_assoc($result);
        $playerName = $row['player_name'];
        return $playerName;
    }
    
    private function getPlayer($playerName) {
        global $query;
        global $connection;
        $selectQuery = $query -> writeSelectQuery("PlayerHas", "*", "name", "=", $playerName);
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $age = $row['age'];
        $jerseyNum = $row['jersey_num'];
        $nationality = $row['nationality'];
        $player = new Player($playerName, $age, $nationality, $jerseyNum);
        return $player;
    }

     public function getAllX($tableName) {
         global $query;
         global $connection;
         $selectQuery = $query -> writeSelectQueryWithoutWhere($tableName, "*");
         $result = mysqli_query($connection, $selectQuery);
         if (!$result) {
             die("FAILED TO OPERATE" . mysqli_error($connection));
         }
         return $result;
     }

}

$user = new User("shiki", "123", false);
$_SESSION['user'] = user;
?>