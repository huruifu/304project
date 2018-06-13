<?php
function ranking_query($table, $c, $n, $b=1){
    // Get top $n from $table ordered by $c; $b is 1 defaultly 
    // means odered by DESC, if $b is 0 then ordered by ASC
        if ($b){
            $query = "SELECT * FROM $table
                    ORDER BY $c DESC
                    LIMIT $n;";
        }
        else {
            $query = "SELECT * FROM $table
                    ORDER BY $c ASC
                    LIMIT $n;";
        }
    return $query;
    }


function topPlayer_game($g_location, $g_time, $team, $record){
    // From $attends table, pick one player in a $team, who got the // highest $record
    // in a game, given its $g_location and $g_time
    //echo 'here';
    $query = "SELECT P.p_name, P.t_name, MAX($record)
                FROM Attends A, Players P
                WHERE A.g_location = '$g_location' AND
                    A.p_name = P.p_name AND A.g_time = '$g_time'
                GROUP BY P.t_name";
    echo $query;
    return $query;

}


function writeSelectQuery($tableName, $selectColumn, $conditionColumn, $operator, $conditionValue) {
        $query = "SELECT $selectColumn ";
        $query .= "FROM $tableName";
        if (!isset($conditionValue)) {
            break;
        }
        elseif (gettype($conditionValue) == "string") {
            $query .= " WHERE $conditionColumn = '$conditionValue' ";
        } 
        else {
            $query .= " WHERE $conditionColumn $operator $conditionValue";
        }
        return $query;
}

function writeAvgQuery($tableName, $selectColumn, $conditionColumn, $conditionValue) {
        $query = "SELECT $conditionColumn, AVG($selectColumn) ";
        $query .= "FROM $tableName ";
        if (gettype($conditionValue) == "string") {
            $query .= "WHERE $conditionColumn = '$conditionValue' ";
            //$query .= "GROUP BY $selectColumn";
        }
//        else if (!isset($conditionColumn)) {
//            $query .= " ";
//        }
        else {
            $query .= "WHERE $conditionColumn = $conditionValue ";
           // $query .= "GROUP BY $selectColumn ";
        }
        return $query;
    }


function writeAggregateQuery($tableName, $aggregation, $aggregateColumn, $selectColumn) {
        $query = "SELECT $selectColumn, $aggregation($aggregateColumn) ";
        $query .= "FROM $tableName ";
        $query .= "GROUP BY $selectColumn ";
        return $query;
    }
 

function insertQuery($tableName, ...$params) {
        $query = "INSERT INTO $tableName ";
        $query .= "VALUES (";
        $length = sizeof($params);
        for ($i=0; $i<$length; $i++) {
            if ($i < $length - 1) {
                echo $params[$i];
                if (gettype($params[$i]) == "string") {
                    $query .= "'$params[$i]', ";
                }
                else {
                    $query .= $params[$i];
                    $query .= ", ";
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

function deleteQuery($tableName, $conditionColumn, $conditionValue) {
        $query = "DELETE FROM $tableName ";
        $query .= "WHERE $conditionColumn = '$conditionValue'";
        return $query;
    }

function teamAvgScores(){
    $t1 = "SELECT t_name1 AS team, sum(scores1) AS sum1 ";
    $t1 .= "FROM Game_play ";
    $t1 .= "GROUP BY t_name1 ";
    
    $t2 = "SELECT t_name2 AS team, sum(scores2) AS sum2 ";
    $t2 .= "FROM Game_play ";
    $t2 .= "GROUP BY t_name2 ";
    
    $joinQuery = "SELECT t1.team AS teamName, t1.sum1 AS t1sum, t2.sum2 AS t2sum ";
    $joinQuery .= "FROM ($t1) AS t1, ($t2) AS t2 ";
    $joinQuery .= "WHERE t1.team = t2.team ";
    
    $sumQuery = "SELECT teamName, t1sum + t2sum ";
    $sumQuery .= "FROM ($joinQuery) AS t3 ";
    
    return $sumQuery;
}
?>