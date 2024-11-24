<?php

    session_start();

    $validation = validarUsuario();

    if (!$validation){
        echo json_encode(
            [
                "status" => "erro",
                "usuario" => 0,
                "nome" => ""
            ]
        );
    }else {
        $userID = catchUSerID();
        $userName = catchUSerName();
        echo json_encode(
            [
                "status" => "validado",
                "usuario" => $userID,
                "nome" => $userName
            ]
        );
    }

?>

<?php

    function validarUsuario(){
        if (isset($_SESSION['userID']) && isset($_SESSION['userName'])){
            $userID = $_SESSION['userID'];
            $userName = $_SESSION['userName'];

            return true;
    
        }elseif(isset($_COOKIE['userID']) && isset($_COOKIE['userName'])){
            $userID = $_COOKIE['userID'];
            $userName = $_COOKIE['userName'];
            return true;
        }else {
            return false;
        }  
    }

?>

<?php

    function catchUSerID(){
        if (isset($_SESSION['userID'])){
            $userID = $_SESSION['userID'];
            return $userID;
    
        }elseif(isset($_COOKIE['userID'])){
            $userID = $_COOKIE['userID'];
            return $userID;
        }else {
            return 0;
        }  
    }

?>

<?php

    function catchUSerName(){
        if (isset($_SESSION['userName'])){
            $userID = $_SESSION['userName'];
            return $userID;
    
        }elseif(isset($_COOKIE['userName'])){
            $userID = $_COOKIE['userName'];
            return $userID;
        }else {
            return "";
        }  
    }

?>