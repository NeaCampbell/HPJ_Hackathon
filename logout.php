<?php
    session_start();
    header('location: home.php');

    unset($_SESSION['login']);

?>
