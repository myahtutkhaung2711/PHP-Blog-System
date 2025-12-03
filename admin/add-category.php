<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../config/config.php');
require_once('../config/connection.php');

include('../includes/head.php')
?>

<?php  include('navbar.php'); ?>

<div class="d-flex">
    <?php include('sidebar.php'); ?>

    <div class="container-fluid p-4">

        <h1 class="mb-3">Add New Category</h1>
        <p class="lead"> Fill out the form below to create a new category.</p>
        <hr>

        <div class="card shadow-sm">
            <div class="card-body">

                <?php
                // Success / Error message
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert alert-info">'.$_SESSION['message'].'</div>';
                    unset($_SESSION['message']);
                }
                ?>

                <form action="add-category-process.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="descripion" rows="6px" class="form-control" required></textarea>
                    </div>
                </form>

                <button tyope-"submit" class="btn btn-outline-dark">Create Cateogy</button>

            </div>
        </div>
    </div>
</div>