<?php

class Query {
    
    // team
    public function ranking_query($table, $c, $n, $b=1){
    // Get top $n from $table ordered by $c; $b is 1 defaultly 
    // means odered by DESC, if $b is 0 then ordered by ASC
        if ($b){
            $query = "SELECT * FROM $table ORDER BY $c DESC LIMIT $n;";
        }
        else {
            $query = "SELECT * FROM $table
                    ORDER BY $c ASC
                    LIMIT $n;";
        }
        return $query;
    }
    
    
    public function topPlayer_game($g_location, $g_time, $team, $record){
    // From $attends table, pick one player in a $team, who got the // highest $record
    // in a game, given its $g_location and $g_time
    //echo 'here';
    $query = "SELECT P.p_name, P.t_name, MAX($record)
                FROM ATTENDS A, PLAYERHAS P
                WHERE A.g_location = '$g_location' AND
                    A.p_name = P.p_name AND A.g_time = '$g_time'
                GROUP BY P.t_name";
        return $query;
    }
    
    
    
    public function writeSelectQuery($tableName, $selectColumn, $conditionColumn, $operator, $conditionValue) {
        $query = "SELECT DISTINCT $selectColumn ";
        $query .= "FROM $tableName ";
        if (gettype($conditionValue) == "string") {
            $query .= " WHERE $conditionColumn = '$conditionValue' ";
        }
        else {
            $query .= " WHERE $conditionColumn $operator $conditionValue ";
        }
        return $query;
    }
    
    public function writeSelectQueryWithoutWhere($tableName, $selectColumn) {
        $query = "SELECT DISTINCT $selectColumn ";
        $query .= "FROM $tableName ";
        return $query;
    }

    public function writeAggregateQuery($tableName, $aggregation, $aggregateColumn, $selectColumn) {
        $query = "SELECT $selectColumn, $aggregation($aggregateColumn) ";
        $query .= "FROM $tableName ";
        $query .= "GROUP BY $selectColumn ";
        return $query;
    }
 
    public function insertQuery($tableName, $params) {
        $query = "INSERT INTO $tableName ";
        $query .= "VALUES (";
        $length = sizeof($params);
        for ($i=0; $i<$length; $i++) {
            if ($i < $length - 1) {
                if (gettype($params[$i]) == "string") {
                    $query .= "'$params[$i]', ";
                }
                else {
                    $query .= "$params[$i], ";
                }
                
            }
            else {
                if (gettype($params[$i]) == "string") {
                    $query .= "'$params[$i]'";
                }
                else {
                    $query .= $params[$i];
                }
            }
        }
        $query .= ") ";
        return $query;
        
    }
    
    public function updateQuery($tableName, $upDateColumn, $value, $condColumn, $condValue) {
        $upDate = "UPDATE $tableName ";
        if (gettype($value) == "string") {
            $upDate .= "SET $upDateColumn = '$value' ";
        }
        else {
            $upDate .= "SET $upDateColumn = $value ";
        }
        
        if (gettype($condValue) == "string") {
            $upDate .= "WHERE $condColumn = '$condValue' ";
        }
        else {
            $upDate .= "WHERE $condColumn = $condValue ";
        }
        return $upDate;
        
    }
    
    public function deleteQuery($tableName, $conditionColumn, $conditionValue) {
        $query = "DELETE FROM $tableName ";
        $query .= "WHERE $conditionColumn = '$conditionValue'";
        return $query;
    }
    
    public function teamAvgScores(){
        $t1 = "SELECT team1 AS team, sum(scores1) AS sum1 ";
        $t1 .= "FROM GAMEPLAY ";
        $t1 .= "GROUP BY team1 ";
    
        $t2 = "SELECT team2 AS team, sum(scores2) AS sum2 ";
        $t2 .= "FROM GAMEPLAY ";
        $t2 .= "GROUP BY team2 ";
    
        $joinQuery = "SELECT t1.team AS teamName, t1.sum1 AS t1sum, t2.sum2 AS t2sum ";
        $joinQuery .= "FROM ($t1) AS t1, ($t2) AS t2 ";
        $joinQuery .= "WHERE t1.team = t2.team ";
    
        $sumQuery = "SELECT teamName, t1sum + t2sum AS totalPoints ";
        $sumQuery .= "FROM ($joinQuery) AS t3 ";
    
        $hostNum = "SELECT team1 AS hostTeam, COUNT(*) AS hostNum ";
        $hostNum .= "FROM GAMEPLAY ";
        $hostNum .= "GROUP BY team1 ";
        
        $guestNum = "SELECT team2 AS guestTeam, COUNT(*) AS guestNum ";
        $guestNum .= "FROM GAMEPLAY ";
        $guestNum .= "GROUP BY team2 ";
        
        $joinQuery1 = "SELECT ht.hostTeam AS team, ht.hostNum AS hostMatch, gt.guestNum AS guestMatch ";
        $joinQuery1 .= "FROM ($hostNum) AS ht, ($guestNum) AS gt ";
        $joinQuery1 .= "WHERE ht.hostTeam = gt.guestTeam ";
        
        $sumNumQuery = "SELECT team, hostMatch + guestMatch AS totalMatch ";
        $sumNumQuery .= "FROM ($joinQuery1) AS jq ";
        
        $divQuery = "SELECT s1.teamName, s1.totalPoints AS points, s2.totalMatch AS matches ";
        $divQuery .= "FROM ($sumQuery) AS s1, ($sumNumQuery) AS s2 ";
        $divQuery .= "WHERE s1.teamName = s2.team ";
        
        $finalQuery .= "SELECT s3.teamName AS team, s3.points/s3.matches ";
        $finalQuery .= "FROM ($divQuery) AS s3 ";
    
        return $finalQuery;
    }
    
    // Given a player, select all games participated, which the players' behaviour satisfied // // certain requirement. 
    // $params is array contains a set of associative arrays.
    public function writeDivisionQuery($params) {
        $length = sizeof($params);
        $divQuery = "SELECT * ";
        $divQuery .= "FROM ATTENDS ";
        $divQuery .= "WHERE ";
        for ($i = 0; $i < $length; $i++) {
            $conditionColumn = key($params[$i]);
            $conditionValue = $params[$i][$conditionColumn];
            $divQuery .= "$conditionColumn > $conditionValue ";
            if ($i < $length - 1) {
                $divQuery .= "AND ";
            }
        }
        return $divQuery;
    }

}


?>
