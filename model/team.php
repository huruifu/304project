<?PHP include "connection.php"; ?>
<?PHP include "query.php"; ?>

<?php
class Team {
    private $city;
    private $teamName;
    private $numWin;
    private $numLoss;
    
    function __construct($city, $teamName, $numWin, $numLoss) {
        $this->city = $city;
        $this->teamName = $teamName;
        $this->numWin=$numWin;
        $this->numLoss=$numLoss;
    }
}


?>