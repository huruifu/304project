<?php 
session_start();
$logins = [];
if (isset($_POST['register'])) {
    $newUserName = $_POST['username'];
    $password = $_POST['password'];
    $logins += [$newUserName => $password];
}
$_SESSION['logins'] =  $logins;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LoginPage</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
</head>
<body>
<div id='form'>
   <form style="display: inline-flex" id='register' action=signup method='post'
    accept-charset='UTF-8'>
<fieldset>
<legend>Sign Up</legend>
    <input type="text" name = "username" placeholder="Enter Username"><br>
    <input type="password" name = "password" placeholder="Enter Password"><br>
    <input type="submit" name = "register" value = "REGISTER">
</fieldset>
</form>
<form style="display: inline-flex" id='sign in' action="form_process.php" method = "post">
<fieldset> 
<legend>Sign In</legend>   
    <input type="text" name = "username" placeholder="Enter Username"><br>
    <input type="password" name = "password" placeholder="Enter Password"><br>
    <input type="submit" name = "submit">
</fieldset>      
</form>
</div>
</body>
</html>