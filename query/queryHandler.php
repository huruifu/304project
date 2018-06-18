<?php include '../model/user.php'; ?>
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
        return '<table><tr><td>Empty Result Set</td></tr></table>';
    }

    // dynamically create the header information from the keys
    // of the result array from mysql
    $table = '<table>';
    $keys = array_keys(reset($results));
    $table.='<thead><tr>';
    foreach ($keys as $key) {
        $table.='<th>'.$key.'</th>';
    }
    $table.='</tr></thead>';

    // populate the main table body
    $table.='<tbody>';
    foreach ($results as $result) {
        $table.='<tr>';
        foreach ($result as $val) {
            $table.='<td>'.$val.'</td>';
        }
        $table.='</tr>';
    }
    $table.='</tbody></table>';
    return $table;
}
    if(isset($_POST['id'])){
        $id=$_POST['id'];
        $params = $_POST['params'];
        echo $params[0];
        $user=new User("shiki", "123", false);
        // $result = $user->getTopTeam('wins', 10);
        // $test = mysqli_fetch_assoc($result);
        // echo json_encode($result);

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
                //TODO 
                break;
            case 'player_q2':
                //TODO  
                break;
            case 'player_q3':
                //TODO 
                break;
            case 'game_q1':
                $result = $user->getTopPlayerInGame($params[3], $params[2], $params[1], $params[0]);
                break;
            case 'game_q2':
                //TODO
                break;
            case 'game_q3':
                //TODO  
                break;
        }
        $tableResult = createTable(array_result($result));
        echo json_encode($tableResult);
        return;
    };

?>