<?php include "../database/connection.php"; ?>
<?php include "../query/query.php"; ?> 

<?php


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
 //
};

if($username == 'testadmin'){
    header('Location:admin.html');
}else{
    // echo '<script>alert("Invalid User! Try Again!");</script>';
}

?>