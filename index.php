<?php
include_once(__DIR__ . '/config/constants.php');
include_once(__DIR__ . '/config/connection.php');
include_once(__DIR__ . '/config/functions.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('includes/header.php');

$query = "
    SELECT posts.*, categories.name AS category_name 
    FROM posts 
    LEFT JOIN categories ON posts.category_id = categories.id 
    WHERE posts.status = 'published'
    ORDER BY posts.id DESC
";
$result = mysqli_query($conn, $query);
?>

<div class="container mt-4">
    <h3 class="mb-4 text-center text-uppercase fw-bold">Latest Blogs</h3>

    <div class="row">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($post = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 border-0">
                        <?php if (!empty($post['image'])): ?>
                            <img src="<?php echo BASE_URL . 'uploads/' . htmlspecialchars($post['image']); ?>" 
                                 class="card-img-top" height="200" alt="Post Image">
                        <?php else: ?>
                            <img src="<?php echo BASE_URL; ?>assets/img/default.jpg" 
                                 class="card-img-top" height="200" alt="Default Image">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="fw-bold"><?php echo htmlspecialchars($post['title']); ?></h5>
                            <p class="text-muted mb-2">
                                <small><?php echo htmlspecialchars($post['category_name']); ?></small>
                            </p>
                            <a href="<?php echo BASE_URL; ?>pages/post.php?id=<?php echo $post['id']; ?>" 
                               class="btn btn-sm btn-outline-primary">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <div class="alert alert-info">No blog posts found.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>
