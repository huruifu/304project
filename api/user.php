<?php include "../database/connection.php" ?>
<?php
session_start();

# ENDPOINTS

# POST /api/user.php?username=...&favourite_team=...
# POST /api/user.php?username=...&favourite_player=...
# POST /api/user.php?username=...&password=... (create account)
# DELETE /api/user.php?username=... (delete account)
# DELETE /api/user.php?username=...&favourite_team=...
# DELETE /api/user.php?username=...&favourite_player=...
# PUT /api/user.php?username=...&password=... (update password) *check password length


$fav_team = $_GET['favourite_team'];
$fav_player = $_GET['favourite_player'];
$username = $_GET['username'];
$password = $_GET['password'];

$method = $_SERVER['REQUEST_METHOD'];

$update_query = "
    UPDATE USERS
    SET PASSWORD = '$password'
    WHERE USERID = '$username'
";

$delete_query = "
    DELETE FROM USERS
    WHERE USERID = '$username'
";

$create_query = "
    INSERT INTO USERS VALUES
    ('$username', 'N', '$password')
";

if (!$username) {
    http_response_code(400);
} else {
    switch ($method) {
        case 'PUT':
            if ($username && $password) {
                if (strlen($password) >= 8) {
                    // update password
                    if (mysqli_query($connection, $update_query)) {
                        http_response_code(200);
                    }
                } else {
                    http_response_code(400);
                }
            }
            break;
        case 'GET':
            http_response_code(405);
            break;
        case 'DELETE':
            if ($username) {
                if ($fav_player) {
                    // delete likedPlayer
                    http_response_code(
                        mysqli_query(
                            $connection,
                            "DELETE FROM USER_LIKEPLAYER WHERE USERID = '$username' AND PLAYER_NAME = '$fav_player'")
                            ? 200 : 400
                    );
                } else if ($fav_team) {
                    // delete likedTeam
                    http_response_code(
                        mysqli_query(
                            $connection,
                            "DELETE FROM USER_LIKETEAM WHERE USERID = '$username' AND TEAM_NAME = '$fav_team'")
                            ? 200 : 400
                    );
                } else {
                    // delete user
                    if (mysqli_query($connection, $delete_query)) {
                        http_response_code(200);
                        $_SESSION['username'] = '';
                    } else {
                        http_response_code(400);
                    }
                }
            }
            break;
        case 'POST':
            if ($password) {
                if (strlen($password) >= 8 && mysqli_query($connection, $create_query)) {
                    http_response_code(200);
                } else {
                    http_response_code(400);
                }
            } else if ($fav_player) {
                // create likedPlayer
                http_response_code(
                    mysqli_query($connection, "INSERT INTO USER_LIKEPLAYER VALUES ('$username', '$fav_player')") ? 200 : 400
                );
            } else if ($fav_team) {
                // create likedTeam
                http_response_code(
                    mysqli_query($connection, "INSERT INTO USER_LIKETEAM VALUES ('$username', '$fav_team')") ? 200 : 400
                );
            }
            break;
        default:
            http_response_code(405);
            break;
    }
}
?>