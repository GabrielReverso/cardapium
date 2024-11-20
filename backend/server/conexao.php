<?php
    $servidor = "localhost:3306";
    $usuarioDB = "root";
    $senhaDB = "123";
    $banco = "cardapiumDB";


    try {
        $connDB = new mysqli($servidor, $usuarioDB, $senhaDB, $banco);
    } catch (\Throwable $th) {
        die("FALHA NA CONEXAO COM O BANCO" . $connDB->connect_error);
    }
    

?>