<?php
// Start session and include config
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../config/config.php');        
require_once('../config/connection.php');    

include('../includes/head.php');

// Fetch all posts with category name
$blogs = $conn->query("
    SELECT posts.*, categories.name AS category_name
    FROM posts
    LEFT JOIN categories ON posts.category_id = categories.id
    ORDER BY posts.id 
");
?>

<?php include('navbar.php'); ?>

<div class="d-flex">
    <?php  include('sidebar.php'); ?>

    <div class="container-fluid mt-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>All Blog Posts</h2>
            <a href="add-blog.php" class="btn btn-outline-success">Create New Post</a>
        </div>
    
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($blogs->num_rows > 0): ?>
                        <?php $serial = 1; ?>
                        <?php while($blog = $blogs->fetch_assoc()): ?>
                            <tr>
                                <td><?= $serial++; ?></td>
                                <td><?= htmlspecialchars($blog['title']); ?></td>
                                <td><?= htmlspecialchars($blog['category_name'] ?? 'Uncategorized'); ?></td>
                                <td><?= date('d M Y', strtotime($blog['created_at'])); ?></td>
                                <td>
                                    <a href="edit-blog.php?id=<?= $blog['id']; ?>" class="btn btn-sm btn-outline-info">Edit</a>
                                    <a href="delete-blog.php?id=<?= $blog['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this blog?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No blogs found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>


<?php include('../includes/footer-script.php'); ?>
