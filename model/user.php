<!-- <?php include "player.php"; ?> -->
<?php include "../query/query.php"; ?>
<?php include "../database/connection.php"; ?>


<?php
$query = new Query();
class User {
    private $userID;
    private $password;
    private $isAdmin;
    private $favoritePLayer = NULL;
    
    
    function __construct($userID, $password, $isAdmin) {
        $this -> userID = $userID;
        $this -> password = $password;
        $this -> isAdmin = $isAdmin;
    }
    
    // get users' favorite player.
    // players' information is in player class.
    public function getFavoritePlayer() {
        $player = $this -> getPlayer($this->favoritePlayer);
        return $player;
    }
    
    // User can update their favorite player.
    public function setFavoritePlayer($playerName) {
        global $query;
        global $connection;
        $updateQuery = $query -> updateQuery("USERS", "favPlayer", $playerName, "userID", $this->userID);
        $result = mysqli_error($connection, $updateQuery);
        if (!$result) {
            die("OPERATOR FAILED " . mysqli_error($connection));
        }
        return $result;
    }
    
    // helper function. used to get the information of users'favorite player.
    private function getPlayer($playerName) {
        if (isset($playerName)) {
            global $query;
            global $connection;
            $selectQuery = $query -> writeSelectQuery("PLAYERHAS", "*", "name", "=", $playerName);
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $age = $row['age'];
            $jerseyNum = $row['jersey_Num'];
            $nationality = $row['nationality'];
            $player = new Player($playerName, $age, $nationality, $jerseyNum);
            return $player;
        }       
    }
    // Teams Query:
    
    //Selecting the top X teams in a season based on the number of winning games.
    public function getTopTeam($orderBy, $topNum) {
        global $query;
        global $connection;
//        echo 'handle~~';
        $queryL = $query -> ranking_query("*", "TEAM", $orderBy, $topNum);
        $result = mysqli_query($connection, $queryL);
        if (!$result) {
            die("FAILED TO OPERATE" . mysqli_error($connection));
        }
        return $result;
    }
    
    
    //Searching for all games related to the user-selected team.
    public function getAllGamesParticipated($teamName) {
        global $query;
        global $connection;
        $selectQuery = "SELECT * ";
        $selectQuery .= "FROM GAMEPLAY ";
        $selectQuery .= "WHERE team1 = '$teamName' OR team2 = '$teamName' ";
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
        $selectQuery = "SELECT * FROM GAMEPLAY WHERE game_time = '$time' AND game_location = '$location' ";
        $result = mysqli_query($connection, $selectQuery);
        if (!$result) {
            die("FAILED TO OPERATE" . mysqli_error($connection));
        }
        return $result;
    }
    
   
    //Games Query
    
    // get player who get the most record in a given game.
    public function getTopPlayerInGame($g_location, $g_time, $team, $record) {
        global $query;
        global $connection;
        $selectQuery = $query -> topPlayer_game($g_location, $g_time, $team, $record);
        $result = mysqli_query($connection, $selectQuery);
        if (!$result) {
            die("FAILED TO OPERATE" . mysqli_error($connection));
        }
        return $result;
    }
    
    // division query;
    // Given 2 types of records (eg: $conditionColumnOne,$conditionColumnTwo), 
    // return all players who have these 2 types of records > 10
    public function getGameMeetRequirement($conditionColumnOne, $conditionColumnTwo) {
        global $query;
        global $connection;
        $divQuery = $query -> writeDivisionQuery($conditionColumnOne,$conditionColumnTwo);
        $result = mysqli_query($connection, $divQuery);
        if (!$result) {
            die("FAILED TO OPERATE" . mysqli_error($connection));
        }
        return $result;
    }
    
    
 
    
    
    
    // Player's Query
    
    //Calculating one player’s average statistics per game (points, rebounds, steals, assists, or blocks).
    // $aggregateColumn is the type of record.
    public function getAverageX($playerName, $aggregateColumn) {
        global $query;
        global $connection;
        $averageQuery = $query -> writeAggregateQuery("ATTENDS", "AVG", $aggregateColumn, "player_name");
        $averageQuery .= "HAVING player_name = '$playerName' ";
        $result = mysqli_query($connection, $averageQuery);
        return $result;
    }
    
    // Calculating EVERY player’s average statistics per game (points, rebounds, steals, assists, or blocks).
    public function getAllPlayerAverageX($aggregateColumn) {
        global $query;
        global $connection;
        $averageQuery = $query -> writeAggregateQuery("ATTENDS", "AVG", $aggregateColumn, "player_name");
        $result = mysqli_query($connection, $averageQuery);
        if (!$result) {
            die("OPERATE FAILED " . mysqli_error($connection));
        }
        return $result;
    }
    
    // get the minimum or maximum among all average.
    // $aggregate is MAX or MIN
    public function getMaxOrMinAvgX($agg, $aggregateColumn, $aggregate) {
        global $query;
        global $connection;
//        $avgQuery = "SELECT p_name AS name, $agg($aggregateColumn) AS info ";
//        $avgQuery .= "FROM ATTENDS ";
//        $avgQuery .= "GROUP BY p_name ";
        
        $avgQuery = $query -> writeAggregateQuery("ATTENDS", $agg, $aggregateColumn, "player_name");
        
        $aggQuery = "SELECT t1.player_name, t1.info ";
        $aggQuery .= "FROM ($avgQuery) AS t1 ";
        $aggQuery .= "WHERE t1.info = (SELECT $aggregate(t2.info) FROM ($avgQuery) AS t2)";
        
//        $aggQueryone = $query -> writeAggregateQuery($tableName, $aggregation, $aggregateColumn, $selectColumn);
//        //$selectQuery = $query -> writeSelectQueryWithoutWhere("($aggQuery)", "*");
//        $aggQueryTwo = "SELECT t1.$selectColumn, $maxMin(t1.info) ";
//        $aggQueryTwo .= "FROM ($aggQueryOne) AS t1 ";
        
        $result = mysqli_query($connection, $aggQuery);
        if (!$result) {
            die("OPERATE FAILED " . mysqli_error($connection));
        }
        return $result;
        
    }
    
    
    
    //Presenting players whose specific statistics in one game (points, rebounds, steals, assists, or blocks) are greater or less than one specific number that users input.
    public function getPlayersMeetRequirment($typeOfRecord, $operator, $value) {
        global $query;
        global $connection;
        $selectQuery = $query -> writeSelectQuery('ATTENDS', 'player_name', $typeOfRecord, $operator, $value);
        $result = mysqli_query($connection, $selectQuery);
        if (!$result) {
            die("FAILED OPERATE" . mysqli_error($connection));
        }
        return $result;
    }
    
    
    //Selecting the top X players in a season based on number of MVP, All-Star
    //requirement is MVP or ALL-STAR
    public function getTopXCareer($num, $requirement) {
        global $query;
        global $connection;
        $selectQuery = $query -> ranking_query('*', 'CAREER', $requirement, $num);
        echo $selectQuery;
        $result = mysqli_query($connection, $selectQuery);
        if (!$result) {
            die("FAILED OPERATE" . mysqli_error($connection));
        }
        return $result;
    }
    
    
    //Selecting the top $num players in a season based on number of $aggregation($orderby),
    //$orderBy is a type of record, eg:points, rebounds, steals, assists, or blocks.
    // $aggregation can be MAX, MIN, AVG or COUNT. (if its COUNT, then $orderBY is "*")
    public function getTopAggStat($aggregation, $num, $orderBy) {
        global $query;
        global $connection;
//        $averageQuery = "SELECT p_name, AVG($orderBy) AS ord ";
//        $averageQuery .= "FROM ATTENDS ";
//        $averageQuery .= "GROUP BY p_name";
//        $rankQuery = "SELECT q1.p_name ";
//        $rankQuery .= "FROM ($averageQuery) AS q1 ";
//        $rankQuery .= "ORDER BY q1.ord ";
//        $rankQuery .= "LIMIT $num ";
        
        $aggQuery = $query -> writeAggregateQuery("ATTENDS", $aggregation, $orderBy, "player_name");
        $rankQuery = $query -> ranking_query("*", "($aggQuery)", "info" , $num, $b=1);
        $result = mysqli_query($connection, $rankQuery);
        if (!$result) {
            die("FAILED OPERATE" . mysqli_error($connection));
        }
        return $result;
    }
    
    
    // Given specific score, rebound, assist, steal and block, choose all players whose average scores, rebounds, assists, steals and blocks is greater than the values respectively.
    public function getPlayerMeetAvgRequirement($typeOfRecord, $operator, $value) {
        global $query;
        global $connection;
        $aggQuery = $query -> writeAggregateQuery("ATTENDS", "AVG", $typeOfRecord, "player_name");
//        $averageQuery = "SELECT p_name, AVG($typeOfRecord) AS ord ";
//        $averageQuery .= "FROM ATTENDS ";
//        $averageQuery .= "GROUP BY p_name";
//        $rankQuery = "SELECT q1.p_name ";
//        $rankQuery .= "FROM ($averageQuery) AS q1 ";
//        $rankQuery .= "WHERE q1.ord $operator $value ";
        
        
        $selectQuery = $query -> writeSelectQuery("($aggQuery)", "*", "info", $operator, $value);
        $result = mysqli_query($connection, $selectQuery);
        if (!$result) {
            die("FAILED OPERATE" . mysqli_error($connection));
        }
        return $result;
    }
    
    
  //-----------------------------------------------------  
    
    
    // get all tuples in a given table.
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
    
    // $params is an array contains values that needed to be inserted.
    // The order of values is the same as the attribute of the given table.
    public function insertData($tableName, $params) {
        global $query;
        global $connection;
        if ($this->isAdmin) {
            $insertQuery = $query -> insertQuery($tableName, $params);
            $result = mysqli_query($connection, $insertQuery);
            if (!$result) {
                die("FAILED TO OPERATE" . mysqli_error($connection));
            }
            echo "OPERATION SUCCESS";
        }
        else {
            die("NO PERMISSION TO  DO THIS OPERATION");
        }
        
    }
    
    
    // delete some tuples. Only admin can do it.
    public function delete($tableName, $conditionColumn, $conditionValue) {
        global $query;
        global $connection;
        if ($this->isAdmin) {
            $delQuery = $query -> deleteQuery($tableName, $conditionColumn, $conditionValue);
            $result = mysqli_query($connection, $delQuery);
            if (!$result) {
                die("FAILED TO OPERATE" . mysqli_error($connection));
            }
            echo "OPERATION SUCCESS";
        }
        else {
            die("NO PERMISSION TO  DO THIS OPERATION");
        }
        
    }
    
    // update some values in some tuples. Only admin can do it.
    public function update($tableName, $upDateColumn, $value, $condColumn, $condValue) {
        global $query;
        global $connection;
        if ($this -> isAdmin) {
            $upQuery = updateQuery($tableName, $upDateColumn, $value, $condColumn, $condValue);
            $result = mysqli_query($connection, $delQuery);
            if (!$result) {
                die("FAILED TO OPERATE" . mysqli_error($connection));
            }
            echo "OPERATION SUCCESS";
        }
        else {
            die("NO PERMISSION TO  DO THIS OPERATION");
        }
    }
}
?>