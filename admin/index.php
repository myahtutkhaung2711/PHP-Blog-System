<?php
    include('../config/connection.php');
    include('../includes/session-check.php');

    if($_SESSION['user_role'] == 1 | $_SESSION['user_role'] == 2) {
        include('navbar.php');
        include('sidebar.php');
        echo "<h1> Welcome, ".$_SESSION['user_name']." </h1>";
    } else {
        echo "Access denied.";
    }
?>