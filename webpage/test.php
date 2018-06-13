<?php
// if(!empty($_POST[''])){
//     $data = [1,2,3];
//     $params = $_POST['params'];
//     echo json_encode($params);
// };
    if(isset($_POST['team'])){
        $data = [1 ,2];
        // echo '<script>alert(!!)</script>';
        echo json_encode($data);
    };

    if(isset($_POST['player'])){
        $data = [1 ,2];
        echo json_encode($data);
    }
?>