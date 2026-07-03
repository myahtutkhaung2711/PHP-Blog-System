<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';

$id = max(0, (int) ($_GET['id'] ?? 0));
$stmt = $conn->prepare('SELECT * FROM categories WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$category = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$category) {
    flash('Category not found.', 'warning');
    redirect(url());
}

$stmt = $conn->prepare('SELECT * FROM posts WHERE category_id = ? AND status = "published" ORDER BY created_at DESC');
$stmt->bind_param('i', $id);
$stmt->execute();
$posts = $stmt->get_result();

$pageTitle = $category['name'] . ' - MHK Blog';
include __DIR__ . '/../includes/header.php';
?>
<main>
    <section class="page-hero compact-hero">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8" data-animate>
                    <span class="eyebrow">Category</span>
                    <h1><?= e($category['name']); ?></h1>
                    <p class="lead text-muted"><?= e($category['description']); ?></p>
                </div>
                <div class="col-lg-4" data-animate>
                    <div class="category-count">
                        <i class="icon-badge">B</i>
                        <strong><?= $posts->num_rows; ?></strong>
                        <span>Published posts</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-pad">
    <div class="container">
        <div class="row g-4">
            <?php if ($posts->num_rows > 0): ?>
            <?php while ($post = $posts->fetch_assoc()): ?>
                <div class="col-md-6 col-lg-4" data-animate>
                    <article class="post-card h-100">
                        <div class="post-image-wrap">
                            <img src="<?= e(postImageUrl($post['image'])); ?>" alt="<?= e($post['title']); ?>">
                        </div>
                        <div class="post-card-body">
                            <h3><?= e($post['title']); ?></h3>
                            <p><?= e(excerpt($post['content'])); ?></p>
                            <a href="<?= url('pages/post.php?id=' . (int) $post['id']); ?>" class="stretched-link read-link">Read More <span>-></span></a>
                        </div>
                    </article>
                </div>
            <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="empty-state">
                        <i class="icon-badge">0</i>
                        <h2>No posts in this category yet.</h2>
                        <a href="<?= url(); ?>" class="btn btn-dark">Back Home</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    </section>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
