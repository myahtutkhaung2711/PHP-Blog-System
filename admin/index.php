<?php
include('../config/constants.php');
include('../config/connection.php');
include('../includes/session-check.php');

// Load the head HTML
include('../includes/head.php');
?>

<?php include('navbar.php'); ?>

<div class="d-flex">

    <!-- Sidebar -->
    <?php include('sidebar.php'); ?>

    <!-- Content -->
    <div class="container-fluid p-4">

        <h1 class="mb-3">
            Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?>!
        </h1>

        <p class="lead">
            You are logged in as 
            <strong><?= ($_SESSION['user_role'] === 'superadmin') ? 'Super Admin' : 'Admin'; ?></strong>.
        </p>

        <hr>

        <div class="row">
            <div class="col-md-3">
                <div class="card shadow-sm text-center p-3">
                    <h3>📝</h3>
                    <p>All Blogs</p>
                    <a href="all-blogs.php" class="btn btn-dark btn-sm">View</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm text-center p-3">
                    <h3>➕</h3>
                    <p>Add Blog</p>
                    <a href="add-blog.php" class="btn btn-dark btn-sm">Add</a>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include('../includes/footer-scripts.php'); ?>
