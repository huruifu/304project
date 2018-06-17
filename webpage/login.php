<?php include "../database/connection.php"; ?>
<?php include "../query/query.php"; ?>


<?php
$query = new query();
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (strlen($password) < 8) {
        # mysql doesn't support checks make sure password is >= 8 characters
        echo '<script>alert("Password must be at least 8 characters long.");</script>';
    } else {
        $result = $connection->query("INSERT INTO Users VALUES ('$username', 'N', '$password')");
        if (!$result) {
            die ("Failed to register " . mysqli_error($connection));
        }
    }
}

if (isset($_POST['sign-in'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result = mysqli_query($connection, "SELECT * FROM Users WHERE userID = '$username' AND password = '$password'");
    if ($result && mysqli_num_rows($result) >= 1) {
        // TODO: user exists, redirect to admin or user page (load favourite player, teams)

        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;

        if (mysqli_fetch_array($result)['isAdmin'] == 'Y') {
            // admin
            $_SESSION['isAdmin'] = true;

        } else {
            // regular user
            $_SESSION['isAdmin'] = false;
        }
        echo '<script>window.location="admin.php";</script>';

    } else {
        echo '<script>alert("Invalid User! Try Again!");</script>';
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
<div id='form'>
   <form style="display: inline-flex" id='register' action='' method='post'
    accept-charset='UTF-8'>

<legend>Sign Up</legend>
    <input type="text" name = "username" placeholder="Enter Username"><br>
    <input type="password" name = "password" placeholder="Enter Password"><br>
    <input type="submit" name = "register" value = "SIGN UP">
</form>

<form style="display: inline-flex" id='sign in' action="" method = "post">
<fieldset>
<legend>Sign In</legend>
    <input type="text" name = "username" placeholder="Enter Username"><br>
    <input type="password" name = "password" placeholder="Enter Password"><br>
    <input type="submit" name = "sign-in" value = "SIGN IN">
</form>
    
</body>
</html>