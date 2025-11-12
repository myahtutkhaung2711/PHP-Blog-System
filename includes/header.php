<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once(__DIR__ . '/../config/constants.php');
include_once(__DIR__ . '/../config/functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MHK Blog</title>

    <!-- ✅ Bootstrap & custom CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?php echo BASE_URL; ?>">MHK Blog</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>pages/about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>pages/contact.php">Contact</a></li>

                <?php if (isset($_SESSION['user_id'])): ?>
                <?php if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] == 'superadmin')): ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>admin/index.php">Dashboard</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link text-danger" href="<?php echo BASE_URL; ?>logout.php">Logout</a></li>
                <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>login.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
