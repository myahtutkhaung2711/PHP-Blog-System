<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../config/config.php');
require_once('../config/connection.php');

include('../includes/head.php');

// Fetch categories for dropdown
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");
?>

<?php include('navbar.php'); ?>

<div class="d-flex">

    <!-- Sidebar -->
    <?php include('sidebar.php'); ?>

    <!-- Main Content -->
    <div class="container-fluid p-4">

        <h1 class="mb-3">Add New Blog</h1>
        <p class="lead">Fill out the form below to create a new blog post.</p>
        <hr>

        <!-- Blog Form -->
        <div class="card shadow-sm">
            <div class="card-body">

                <?php 
                // Success / Error message
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert alert-info">'.$_SESSION['message'].'</div>';
                    unset($_SESSION['message']);
                }
                ?>

                <form action="add-blog-process.php" method="POST" enctype="multipart/form-data">

                    <!-- Title -->
                    <div class="mb-3">
                        <label class="form-label">Blog Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            <?php while ($cat = $categories->fetch_assoc()) { ?>
                                <option value="<?= $cat['id']; ?>">
                                    <?= htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Image -->
                    <div class="mb-3">
                        <label class="form-label">Featured Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <!-- Content -->
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="content" rows="6" class="form-control" required></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-outline-dark">Create Blog</button>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer-script.php'); ?>
