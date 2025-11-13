<?php
include_once(__DIR__ . '/../config/constants.php');
session_start();

if (!isset($_SESSION['user_role'])) {
    header("Location: " . BASE_URL . "login.php");
    exit();
}
?>
