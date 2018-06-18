<?php include "../database/connection.php" ?>
<?php

# ENDPOINTS

# GET /api/coaches.php

$query = "SELECT * FROM COACH";

$array = array();
if ($result = mysqli_query($connection,$query)) {

    while($row = mysqli_fetch_assoc($result)) {
        $array[] = $row;
    }
}

echo json_encode($array);

?>