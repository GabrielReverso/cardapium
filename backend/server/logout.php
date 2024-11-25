<?php
    header("Access-Control-Allow-Origin: http://localhost:8080");
    header("Access-Control-Allow-Credentials: true");
    setcookie("userID", "", time() - 2592001, "localhost", false, true);
    setcookie("userName", "", time() - 2592001, "localhost", false, true);
?>