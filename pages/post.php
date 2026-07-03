<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';

$id = max(0, (int) ($_GET['id'] ?? 0));
$stmt = $conn->prepare("
    SELECT posts.*, categories.name AS category_name, users.name AS author_name
    FROM posts
    LEFT JOIN categories ON posts.category_id = categories.id
    LEFT JOIN users ON posts.user_id = users.id
    WHERE posts.id = ? AND posts.status = 'published'
    LIMIT 1
");
$stmt->bind_param('i', $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$post) {
    flash('Post not found.', 'warning');
    redirect(url());
}

$pageTitle = $post['title'] . ' - MHK Blog';
include __DIR__ . '/../includes/header.php';
?>
<main>
    <section class="post-hero">
        <div class="container">
            <a href="<?= url('#blog'); ?>" class="back-link">Back to posts</a>
            <div class="row align-items-end g-4 mt-2">
                <div class="col-lg-8" data-animate>
                    <span class="badge text-bg-light"><?= e($post['category_name'] ?? 'Uncategorized'); ?></span>
                    <h1 class="mt-3"><?= e($post['title']); ?></h1>
                    <p class="text-muted">By <?= e($post['author_name'] ?? 'Admin'); ?> on <?= date('M d, Y', strtotime($post['created_at'])); ?></p>
                </div>
                <div class="col-lg-4" data-animate>
                    <div class="article-meta-panel">
                        <div><i class="icon-badge">A</i><span>Article</span></div>
                        <div><i class="icon-badge">C</i><span><?= e($post['category_name'] ?? 'Uncategorized'); ?></span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <article class="container post-detail section-pad pt-4">
        <img class="post-detail-img" src="<?= e(postImageUrl($post['image'])); ?>" alt="<?= e($post['title']); ?>" data-animate>
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="post-content content-panel" data-animate>
                    <?= nl2br(e($post['content'])); ?>
                </div>
            </div>
            <aside class="col-lg-4">
                <div class="info-card sticky-note" data-animate>
                    <i class="icon-badge">R</i>
                    <h2>Enjoying this article?</h2>
                    <p>Explore more posts from the homepage or send feedback through the contact page.</p>
                    <a href="<?= url('pages/contact.php'); ?>" class="btn btn-outline-dark w-100">Send Feedback</a>
                </div>
            </aside>
        </div>
    </article>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
