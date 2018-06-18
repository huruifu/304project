<?php include '../model/user.php' ?>
<?php
function array_result($result)
{
    $args = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $args[] = $row;
    }
    return $args;
}


/**
 * Create a table from a result set
 *
 * @param array $results
 * @return string
 */
function createTable(array $results = array())
{
    if (empty($results)) {
        return 'There is no result for your query, please try again.';
    }

    // dynamically create the header information from the keys
    // of the result array from mysql
    $table = '<table>';
    $keys = array_keys(reset($results));
    $table.='<thead><tr>';
    foreach ($keys as $key) {
        $table.='<th>'.$key;
    }

    // populate the main table body
    $table.='<tbody>';
    foreach ($results as $result) {
        $table.='<tr>';
        foreach ($result as $val) {
            $table.='<td>'.$val;
        }
    }
    return $table;
}
    if(isset($_POST['id'])) {
        $id=$_POST['id'];
        $params = $_POST['params'];
//        echo $params[0];
        $user=new User("shiki", "123", false);

        switch ($id) {
            case 'team':
                $result = $user->getAllX('team');
                break;
            case 'game':
                $result = $user->getAllX('gameplay');
                break;
            case 'player':
                $result = $user->getAllX('playerhas');
                break;
            case'team_q1':
                $result = $user->getTopTeam($params[1], $params[0]);
                break;
            case 'team_q2':
                $result = $user->getAllGamesParticipated($params[0]);
                break;
            case 'team_q3':
                $result = $user->selectSpecificGame($params[1], $params[0]);
                break;
            case 'player_q1':
                $result = $user->getAverageX($params[0], $params[1]);
                break;
            case 'player_q2':
                $result = $user->getAllPlayerAverageX($params[0]);
                break;
            case 'player_q3':
                $result = $user->getMaxOrMinAvgX($params[1], $params[0], $params[2]);
                break;
            case 'player_q4':
                $result = $user->getPlayersMeetRequirment($params[0], $params[1], $params[2]);
                break;
            case 'player_q5':
                $requirement = $params[1].'_NUM';
                $result = $user->getTopXCareer($params[0], $requirement);
                break;
            case 'player_q6':
            break;
            case 'player_q7':
                $result = $user->getPlayerMeetAvgRequirement($params[0], $params[1], $params[2]);
                break;
            case 'game_q1':
                $result = $user->getTopPlayerInGame($params[1], $params[0], $params[2], $params[3]);
                break;
            case 'game_q2':
                $result = $user->getGameMeetRequirement($params[0], $params[1]);
                break;

        }
        $tableResult = createTable(array_result($result));
        echo $tableResult;
        return;
    };

?>