<?php include "../database/connection.php"; ?>
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

$username = $_POST['username'];
$password = $_POST['password'];

// if($username == 'testuser'){
//     header('Location:user.html');
// }else{
//     echo '<script>alert("Invalid User! Try Again!");</script>';
// }
if($_POST['register'] == 'REGISTER'){
    registerQuery($username, 'N', $password);
}
else{
    echo 'test';
};

if($username == 'testadmin'){
    header('Location:admin.html');
}else{
    // echo '<script>alert("Invalid User! Try Again!");</script>';
}

?>