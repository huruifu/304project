<?PHP include "connection.php"; ?>
<?PHP include "query.php"; ?>
<?php
session_start();
$query = $_SESSION['query'];
class Player {
    private $name;
    private $age;
    private $nationality
    private $jerseyNum;
    
    function __construct($name, $age, $nationality, $jerseyNum) {
        $this->name = $name;
        $this->age = $age;
        $this->nationality = $nationality;
        $this->jerseyNum = $jerseyNum;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getAge() {
        return $this->age;
    }
    
    public function getNationality() {
        return $this->nationality;
    }
    
    public function getJerseyNum() {
        return this->$jerseyNum;
    }
    
    
    public function getAverageScore() {
        $row = getResult("Attend", "points");
        $averageScore = $row['AVG(points)'];
        return $averageScore;
    }
                
    
    public function getAverageRebond() {
        $row = getResult("Attend", "rebounds");
        $averageRebound = $row['AVG(rebounds)'];
        return $averageRebound;
    }
    
    public function getAverageAssist() {
        $row = getResult("Attend", "assists");
        $averageAssist = $row['AVG(assists)'];
        return $averageAssist;
    }
    
    public function getAverageBlock() {
        $row = getResult("Attend", "blocks");
        $averageBlock = $row['AVG(blocks)'];
        return $averageBlock;
    }
    
    public function getAverageSteal() {
        $row = getResult("Attend", "steals");
        $averageSteal = $row['AVG(steals)'];
        return $averageSteal;
    }
    
    private function getResult($tableName, $selectColumn) {
        global $connection;
        global $query;
        $averageQuery = $query -> writeAvgQuery($tableName, $selectColumn, "player_name", $this->name);
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }
}




?>