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
</head>
<body>
  
   <form id='register' action='login.html' method='post' 
    accept-charset='UTF-8'>
<fieldset>
<legend>Sign Up</legend>
    <input type="text" name = "username" placeholder="Enter Username"><br>
    <input type="password" name = "password" placeholder="Enter Password"><br>
    <input type="submit" name = "register" value = "REGISTER">

</fieldset>
</form>
   
   
<form id = 'sign in' action="form_process.php" method = "post">
<fieldset> 
<legend>Sign In</legend>   
    <input type="text" name = "username" placeholder="Enter Username"><br>
    <input type="password" name = "password" placeholder="Enter Password"><br>
    <input type="submit" name = "submit">
</fieldset>      
</form>
    
</body>
</html>