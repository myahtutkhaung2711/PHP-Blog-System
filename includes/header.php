<?php
// Optional: include constants or session start
include_once(__DIR__ . '/../config/constants.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Management System</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">

    <!-- Google Fonts (optional) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?php echo BASE_URL; ?>">My Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>">Home</a>
                </li>

                <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>categories.php">Categories</a>
                </li>

                <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>about.php">About</a>
                </li>

                <?php if(isset($_SESSION['user_role'])): ?>
                <?php if($_SESSION['user_role'] == ROLE_ADMIN || $_SESSION['user_role'] == ROLE_SUPER): ?>
                    <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>admin/">Dashboard</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="<?php echo BASE_URL; ?>logout.php">Logout</a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>login.php">Login</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<!-- Navbar End -->

<div class="container mt-4">
