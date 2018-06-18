<!-- <?php 
$pathOne = $_SERVER['DOCUMENT_ROOT'];
$pathOne .= "/database/connection.php";
include $pathOne;

$pathTwo = $_SERVER['DOCUMENT_ROOT'];
$pathTwo .= "/model/user.php";
include $pathTwo;
?> -->


<?php
session_start();
$user = $_SESSION['user'];
    //$user = new user("shiki", "123", false);
if(isset($_POST['test'])){
    $user -> getAllgames();
    $data = [1 ,2];
        // $result = $user->getAllX("teams");
    echo json_encode($data);
}

if(isset($_POST['player'])){
    $data = [1 ,2];
    echo json_encode($data);
}
?>