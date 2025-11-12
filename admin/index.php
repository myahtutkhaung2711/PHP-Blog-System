<?php
include('../config/connection.php');
include('../includes/session-check.php');

if ($_SESSION['user_role'] == 1 || $_SESSION['user_role'] == 2) {
    include('navbar.php');
    include('sidebar.php');

    echo "<div class='container mt-4'>";
    echo "<h1>Welcome, " . htmlspecialchars($_SESSION['user_name']) . "!</h1>";
    echo "<p>You are logged in as <strong>" . 
        ($_SESSION['user_role'] == 2 ? 'Super Admin' : 'Admin') . "</strong>.</p>";
    echo "</div>";
} else {
    echo "Access denied.";
}
?>
