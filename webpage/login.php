<!-- <?php include "../database/connection.php"; ?> -->
<?php include "../query/query.php"; ?> 


<?php 
function registerQuery($userID, $isAdmin, $password) {
    global $query;
    global $connection;
    $insertQuery = "INSERT INTO USERS VALUES ('$userID', '$isAdmin', '$password', 'test_player') ";
    $result = mysqli_query($connection, $insertQuery);
    if (!$result) {
        die("FAILED TO OPERATE" . mysqli_error($connection));
    }
}
function getUser($userID) {
    global $query;
    global $connection;
    $selectQuery = $query -> writeSelectQuery("USERS", "*", "userID","=", $userID);
    $result = mysqli_query($connection, $selectQuery);
    if (!$result) {
        die("FAILED TO OPERATE" . mysqli_error($connection));
    }
    $row = mysqli_fetch_row($result);
    $isAdmin = $row[1];
    $password = $row[2];
    $favPlayer = $row[3];
    $user = new User($userID, $isAdmin, $password);
    return $user;
}

function checkUser($userID, $password) {
    global $query;
    global $connection;
    $q1 = "SELECT count(*) ";
    $q1 .= "FROM USERS ";
    $q1 .= "WHERE userID = '$userID' AND password = '$password' ";
    $result = mysqli_query($connection, $q1);
    if (!$result) {
        die("OPERATION FAILED" . mysqli_error($connection));
    }
    $row = mysqli_fetch_row($result);
    $count = $row[0];
    return $count;
}

if (isset($_POST['register'])) {
    $userName = $_POST['username'];
    $password = $_POST['password'];
    registerQuery($userName, 'N', $password);
    echo 'Successfully registered!';
}

if(isset($_POST['signin'])){
    $userName = $_POST['username'];
    $password = $_POST['password'];
    checkUser($userName, $password);
    if(checkUser($userName, $password)){
        header('Location:user.html');
    } else if($userName == 'testadmin') {
        header('Location:admin.html');
    }else {
        echo 'hafwkhaf';
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
   <form style="display: inline-flex" id='register' method='post'
    accept-charset='UTF-8'>
    <fieldset name='register'>
<legend>Sign Up</legend>
    <input type="text" name = "username" placeholder="Enter Username"><br>
    <input type="password" name = "password" placeholder="Enter Password"><br>
    <input type="submit" name = "register" value = "REGISTER">
</fieldset>
</form>
<form style="display: inline-flex" id='signin' method = "post" accept-charset='UTF-8'>
<fieldset name="signin"> 
<legend>Sign In</legend>   
    <input type="text" name = "username" placeholder="Enter Username"><br>
    <input type="password" name = "password" placeholder="Enter Password"><br>
    <input type="submit" name = "signin" value = "SIGN IN">    
    </fieldset> 
</form>
</div>
</body>
</html>