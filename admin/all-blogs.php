<?php
// Start session and include config
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../config/config.php');        
require_once('../config/connection.php');    

include('../includes/head.php');

// Fetch all posts with category name
$posts = $conn->query("
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
            <a href="create-post.php" class="btn btn-success">Create New Post</a>
        </div>
    
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($posts->num_rows > 0): ?>
                        <?php while($post = $posts->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $post['id']; ?></td>
                                <td><?php echo htmlspecialchars($post['title']); ?></td>
                                <td><?php echo htmlspecialchars($post['category_name'] ?? 'Uncategorized'); ?></td>
                                <td><?php echo htmlspecialchars($post['author'] ?? 'Admin'); ?></td>
                                <td><?php echo date('d M Y', strtotime($post['created_at'])); ?></td>
                                <td>
                                    <a href="edit-post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                                    <a href="delete-post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No posts found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>


<?php include('../includes/footer-script.php'); ?>
