<?php 
if (isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    echo "Hi!". $username;
    echo "<br>";
    echo "Your password is ". $password;

$connection = mysqli_connect('localhost','root', 'root', 'loginapp');
if ($connection){
    echo "<br>";
    echo "Connected!";
}
else {
    die ("Lose connection");
    }
    
    
$insert_query = "INSERT INTO users(username, password) VALUE ('$username', '$password')";

$result = mysqli_query($connection, $insert_query);
if (!$result){
    die('Fail to insert' .mysqli_error);
        
}

    
    
    
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body background = "bc-wallpaper.jpg">
   
<form action="_form.php"
   method="post">
   
<input type="text"
  name = "username"
   placeholder="Enter Username">
<br>
   
<input type="password"
  name = "password"
   placeholder="Enter Password">
<br>

<input type="submit"
   name="submit">
    
</form>
    
</body>
</html>