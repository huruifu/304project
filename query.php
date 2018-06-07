<?php

class Query {
    
    public function writeSelectQuery($tableName, $selectColumns, $conditionColumns, $conditionOperators, $conditionValues, $logic) {
        $query = writeSelectColumns($selectColumns);
        $query .= writeFrom($tableName);
        $query .= writeWhereCondition($conditionColumns, $conditionOperators, $conditionValues, $logic)
        return $query;
    }
    
    public function writeAvgQuery($tableName, $selectColumn, $conditionColumn, $conditionValue) {
        $query = "SELECT AVG('$selectColumn') ";
        $query .= writeFrom($tableName);
        $query .= writeWhereCondition($conditionColumn, $conditionOperator, $conditionValue, NULL);
        return $query;
    }

    private function writeWhereCondition($conditionColumns, $conditionOperators, $conditionValues, $logic) {
        $query = "WHERE ";
        if (!is_array($conditionColumns)) {
            $query .= writePartialCondition($conditionColumns, $conditionOperators, $conditionValues);
        }
        else {
            $query .= writeConditionArray($conditionColumns, $conditionOperators, $conditionValues, $logic);
        }
        return $query;
    }
    
    private function writeConditionArray($conditionColumns, $conditionOperators, $conditionValues, $logic) {
        $query = "";
        $length = sizeof($conditionColumns);
        for ($i = 0; $i < $length; $i++) {
            $query .= writePartialCondition($conditionColumns[$i], $conditionValues[$i]);
            if ($i < $length - 1) {
                $query .= $logic;
            }
            else {
                $query .= ";";
            }
        }
        return $query;
    }
    
    private function writePartialCondition($conditionColumn, $conditionOperator, $conditionValue) {
        $query = "";
        if (gettype($conditionValues) == "string") {
            $query = writeStringCondition($conditionColumn, $conditionOperator, $conditionValue);
        }
        else {
            $query = writeNonStringCondition($conditionColumn, $conditionOperator, $conditionValue);
        }
        return $query;
    }
    
    private function writeStringCondition($conditionColumn, $conditionOperator, $conditionValue) {
        $query = "'$conditionColumn' '$conditionOperator' '$conditionValue' ";
        return $query;
    }
    
    private function writeNonStringCondition($conditionColumn, $conditionOperator, $conditionValue) {
        $query = "'$conditionColumn' '$conditionOperator' $conditionValue ";
        return $query;
    }
    
    private function writeFrom($tableName) {
        $query = "FROM TABLE '$tableName' ";
        return $query;
    }


    private function writeSelectColumns($selectColumns) {
        $query = "SELECT ";
        if (!is_array($selectColumns)) {
            $query .= $selectColumns;
        }
        else {
            $query .= writeSelectWithArray($selectColumns);
        }
        return $query;
    }
    
    private function writeSelectWithArray($selectColumns) {
        $query = "";
        $length = sizeof($selectColumns);
        for ($i = 0; $i < $length; $i++) {
            if ($i < $length - 1) {
                $query .= "$selectColumns[$i], ";
            }
            else {
                $query .= "$selectColumns[$i] ";
            }
        }
        return $query;
    }

}

$query = new Query();
session_start();
$_SESSION['query'] = $query;


?>