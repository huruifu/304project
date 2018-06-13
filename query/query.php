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
    
    // public function writeUnion($query1, $query2) {
    //     $query = "";
    //     $query .= $query1;
    //     $query .= " UNION ";
    //     $query .= $query2;
    //     return $query;
    // }
    
    // public function writeIntersection($query1, $query2) {
    //     $query = "";
    //     $query .= $query1;
    //     $query .= " INTERSECTION ";
    //     $query .= $query2;
    //     return $query;
    // }
    
    public function writeAvgQuery($tableName, $selectColumn, $conditionColumn, $conditionValue) {
        $query = "SELECT $selectColumn, AVG('$selectColumn') ";
        $query .= "FROM $tableName ";
        if (gettype($conditionValue) == "string") {
            $query .= "WHERE $conditionColumn = '$conditionValue' ";
            $query .= "GROUP BY $selectColumn ";
        }
        else if (!isset($conditionColumn)) {
            $query .= " ";
        }
        else {
            $query .= "WHERE $conditionColumn = $conditionValue ";
            $query .= "GROUP BY $selectColumn ";
        }
        return $query;
    }
    
    public function deleteQuery($tableName, $selectColumn, $conditionColumn, $conditionValue) {
        $query = "DELETE FROM $tableName ";
        $query .= "WHERE $conditionColumn = '$conditionValue'";
        return $query;
    }
    
    // public function insertQuery($tableName, ...$params) {
    //     $query = "INSERT INTO $tableName ";
    //     $query .= "VALUES (";
    //     $length = sizeof($params);
    //     for ($i=0; $i<$length; $i++) {
    //         if ($i < $length - 1) {
    //             if (gettype($params[$i]) == "string") {
    //                 $query .= "'$params[$i]', ";
    //             }
    //             else {
    //                 $query .= $params[$i];
    //                 $query .= ", ";
    //             }
                
    //         }
    //         else {
    //             if (gettype($params[$i]) == "string") {
    //                 $query .= "'$params[$i]' ";
    //             }
    //             else {
    //                 $query .= $params[$i];
    //             }
    //         }
    //     }
    //     $query .= ") ";
    //     return $query;
        
    // }
    
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

    
    
    
    
    
    
    
    
    
//    public function writeSelectQuery($tableName, $selectColumns, $conditionColumns, $conditionOperators, $conditionValues, $logic) {
//        $query = writeSelectColumns($selectColumns);
//        $query .= writeFrom($tableName);
//        $query .= writeWhereCondition($conditionColumns, $conditionOperators, $conditionValues, $logics);
//        return $query;
//    }
//    
//    public function writeAvgQuery($tableName, $selectColumn, $conditionColumn, $conditionValue) {
//        $query = "SELECT AVG('$selectColumn') ";
//        $query .= writeFrom($tableName);
//        $query .= writeWhereCondition($conditionColumn, $conditionOperator, $conditionValue, NULL);
//        return $query;
//    }
//    
//    public function writeUpdateQuery($tableName, $setColumns, $setValues, $conditionColumns, $conditionValues) {
//        $query = "UPDATE $tableName ";
//        $query .= writeWhereCondition($conditionColumns, "=", $conditionValues, NULL);
//        return $query;
//        
//    }
//    
//    private function writeSet($setColumns, $setValues) {
//        $query = "SET ";
//        if (!is_array($setColumns)) {
//            $query .= writeOneSet($setColumns, $setValues);
//        }
//        else {
//            $query .= writeSetArray($setColumns, $setValues);
//        }
//        return $query;
//    }
//    
//    private function writeArraySet($setColumns, $setValues) {
//        $length = sizeof($setColumns);
//        $query = "";
//        for ($i=0; $i < $length; $i++) {
//            $query .= writeOneSet($setColumns[$i], $setValues[$i]);
//            if ($i < $length - 1) {
//                $query .= ", ";
//            }
//        }
//        return $query;
//    }
//    
//    private function writeOneSet($setColumn, $setValue) {
//        $query = "";
//        if (gettype($setValue) == "string") {
//            $query .= "$setColumn = '$setValue'";
//        }
//        else {
//            $query .= "$setColumn = $setValue";
//        }
//        return $query;
//    }
//
//    private function writeWhereCondition($conditionColumns, $conditionOperators, $conditionValues, $logics) {
//        $query = "WHERE ";
//        if (!is_array($conditionColumns)) {
//            $query .= writePartialCondition($conditionColumns, $conditionOperators, $conditionValues);
//        }
//        else {
//            $query .= writeConditionArray($conditionColumns, $conditionOperators, $conditionValues, $logic);
//        }
//        return $query;
//    }
//    
//    private function writeConditionArray($conditionColumns, $conditionOperators, $conditionValues, $logic) {
//        $query = "";
//        $length = sizeof($conditionColumns);
//        for ($i = 0; $i < $length; $i++) {
//            $query .= writePartialCondition($conditionColumns[$i], $conditionValues[$i]);
//            if ($i < $length - 1) {
//                $query .= $logic;
//            }
//            else {
//                $query .= ";";
//            }
//        }
//        return $query;
//    }
//    
//    private function writePartialCondition($conditionColumn, $conditionOperator, $conditionValue) {
//        $query = "";
//        if (gettype($conditionValues) == "string") {
//            $query = writeStringCondition($conditionColumn, $conditionOperator, $conditionValue);
//        }
//        else {
//            $query = writeNonStringCondition($conditionColumn, $conditionOperator, $conditionValue);
//        }
//        return $query;
//    }
//    
//    private function writeStringCondition($conditionColumn, $conditionOperator, $conditionValue) {
//        $query = "$conditionColumn $conditionOperator '$conditionValue' ";
//        return $query;
//    }
//    
//    private function writeNonStringCondition($conditionColumn, $conditionOperator, $conditionValue) {
//        $query = "$conditionColumn $conditionOperator $conditionValue ";
//        return $query;
//    }
//    
//    private function writeFrom($tableName) {
//        $query = "FROM TABLE $tableName ";
//        return $query;
//    }
//
//
//    private function writeSelectColumns($selectColumns) {
//        $query = "SELECT ";
//        if (!is_array($selectColumns)) {
//            $query .= $selectColumns;
//        }
//        else {
//            $query .= writeSelectWithArray($selectColumns);
//        }
//        return $query;
//    }
//    
//    private function writeSelectWithArray($selectColumns) {
//        $query = "";
//        $length = sizeof($selectColumns);
//        for ($i = 0; $i < $length; $i++) {
//            if ($i < $length - 1) {
//                $query .= "$selectColumns[$i], ";
//            }
//            else {
//                $query .= "$selectColumns[$i] ";
//            }
//        }
//        return $query;
//    }

}

$query = new Query();
session_start();
$_SESSION['query'] = $query;


?>