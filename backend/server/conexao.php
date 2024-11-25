<?php
    $servidor = "localhost:3306";
    $usuarioDB = "root";
    $senhaDB = "123";
    $banco = "cardapiumDB";

    //header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Origin: http://localhost:8080");
    header("Access-Control-Allow-Credentials: true");

    try {
        $connDB = new mysqli($servidor, $usuarioDB, $senhaDB, $banco);
    } catch (\Throwable $th) {
        die("FALHA NA CONEXAO COM O BANCO" . $connDB->connect_error);
    }
    

?>