
<?php
    if(isset($_POST['test'])){
        $data = [1 ,2];
        // $result = $user->getAllX("teams");
        // echo '<script>alert(!!)</script>';
        echo json_encode($data);
    };

    if(isset($_POST['player'])){
        $data = [1 ,2];
        echo json_encode($data);
    };
?>