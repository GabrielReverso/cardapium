<?php

    session_start();
    session_unset();
    session_destroy();

    setcookie("userID", "", time() - 2592001, "/");
    setcookie("userName", "", time() - 2592001, "/");

    header("Location: login.html");
?>