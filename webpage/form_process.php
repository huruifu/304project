<?php

$username = $_POST['username'];
$password = $_POST['password'];

if($username == 'vincy'){
    header('Location:admin.html');
}else{
    echo '<script>alert("Invalid User! Try Again!");</script>';
}
?>