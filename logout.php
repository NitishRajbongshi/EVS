<?php
    session_start();
    session_unset();
    session_destroy();
    header('location: /php_tutorial/EVS/index.php');
?>