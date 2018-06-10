<?php include "../database/connection.php"; ?>
<?php include "../query/query.php"; ?>


<?php 
$query = new query();
if (isset($_POST['register'])) {
    $userName = $_POST['username'];
    $password = $_POST['password'];
    $insertQuery = $query -> insertQuery("USERS", $userName, $password, false);
    $result = mysqli_query($connection, $insertQuery);
    if (!$result) {
        die ("Failed to register " . mysqli_error($connection));
    }
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LoginPage</title>
    <link rel="stylesheet" type="text/css" href="login_style.css">
</head>
<body>
  
   <form id='register' action='login.php' method='post' 
    accept-charset='UTF-8'>

<legend>Sign Up</legend>
    <input type="text" name = "username" placeholder="Enter Username"><br>
    <input type="password" name = "password" placeholder="Enter Password"><br>
    <input type="submit" name = "register" value = "SIGN UP">
</form>
   
   
<form id = 'sign in' action="login.php" method = "post">

<legend>Sign In</legend>   
    <input type="text" name = "username" placeholder="Enter Username"><br>
    <input type="password" name = "password" placeholder="Enter Password"><br>
    <input type="submit" name = "submit" value = "SIGN IN">     
</form>
    
</body>
</html>