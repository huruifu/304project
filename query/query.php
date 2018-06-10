<?php

class Query {
    
    public function writeSelectQuery($tableName, $selectColumn, $conditionColumn, $operator, $conditionValue) {
        $query = "SELECT $selectColumn ";
        $query .= "FROM $tableName ";
        if (isset($conditionColumn)) {
            if (gettype($conditionValue) == "string") {
                $query .= "WHERE $conditionColumn = '$conditionValue' ";
            } 
            else {
                $query .= "WHERE $conditionColumn $operator $conditionValue ";
            }
        }
        return $query;
    }
    
    public function writeUnion($query1, $query2) {
        $query = "";
        $query .= $query1;
        $query .= " UNION ";
        $query .= $query2;
        return $query;
    }
    
    public function writeIntersection($query1, $query2) {
        $query = "";
        $query .= $query1;
        $query .= " INTERSECTION ";
        $query .= $query2;
        return $query;
    }
    
    public function writeAggregateQuery($tableName, $aggregation, $aggregateColumn, $selectColumn) {
        $query = "SELECT $selectColumn, $aggregation($aggregateColumn) ";
        $query .= "FROM $tableName ";
        $query .= "GROUP BY $selectColumn ";
        return $query;
    }
    
    public function deleteQuery($tableName, $selectColumn, $conditionColumn, $conditionValue) {
        $query = "DELETE FROM $tableName ";
        $query .= "WHERE $conditionColumn = '$conditionValue'";
        return $query;
    }
    
    public function insertQuery($tableName, ...$params) {
        $query = "INSERT INTO $tableName ";
        $query .= "VALUES (";
        $length = sizeof($params);
        for ($i=1; $i<$length-1; $i++) {
            if ($i < length - 1) {
                if (gettype($params[i]) == "string") {
                    $query .= "'$params[i]', ";
                }
                else {
                    $query .= $params[i];
                    $query .= ", ";
                }
                
            }
            else {
                if (gettype($params[i]) == "string") {
                    $query .= "'$params[i]'";
                }
                else {
                    $query .= $params[i];
                }
            }
        }
        $query .= ") ";
        return $query;
        
    }
    
    public function upDateQuery($tableName, $setColumn, $setValue, $conditonColumn, $conditionValue) {
        $query = "UPDATE $stableName ";
        if (isset($setValue) == "string") {
            $query .= "SET $setColumn = '$setValue' ";
        }
        else {
            $query .= "SET $setColumn = $setValue ";
        }
        if (isset($conditionValue) == "string") {
            $query .= "WHERE $conditionColumn = '$conditionValue' ";
        }
        else {
            $query .= "WHERE $conditionColumn = $conditionValue ";
        }
        return query;
    }

}

$query = new Query();
session_start();
$_SESSION['query'] = $query;


?>