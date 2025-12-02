<?php 
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../config/config.php');
require_once('../config/connection.php');

include('../includes/head.php');

$categories = $conn->query("
    SELECT * FROM categories ORDER BY name ASC
");
?>

<?php include('navbar.php'); ?>

<div class="d-flex">
    <?php include('sidebar.php') ?>

    <div class="container-fluid mt-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>All Categories</h2>
            <a href="add-category.php" class="btn btn-outline-success">Add New Category</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($categories->num_rows > 0): ?>
                        <?php $serial = 1; ?>
                        <?php while($category = $categories->fetch_assoc()): ?>
                            <tr>
                                <td><?= $serial++ ?></td>
                                <td><?= htmlspecialchars($category['name']); ?></td>
                                <td>
                                    <a href="edit-category.php?id=<?= $category['id']; ?>" class="btn btn-sm btn-outline-info">Edit</a>
                                    <a href="delete-category.php?id=<?= $category['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No categories found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('../includes/footer-scripts.php'); ?>