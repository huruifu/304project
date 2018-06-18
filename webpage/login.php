<!-- <?php include "../database/connection.php"; ?>
<?php include "../query/query.php"; ?> -->


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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
</head>
<body>
<div id='form'>
   <form style="display: inline-flex" id='register' action="form_process.php" method='post'
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
    <input type="submit" name = "submit" value = "SIGN IN">    
    </fieldset> 
</form>
</div>
</body>
</html>