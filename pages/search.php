<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';

$q = trim($_GET['q'] ?? '');
$like = '%' . $q . '%';
$stmt = $conn->prepare('SELECT * FROM posts WHERE status = "published" AND (title LIKE ? OR content LIKE ?) ORDER BY created_at DESC');
$stmt->bind_param('ss', $like, $like);
$stmt->execute();
$posts = $stmt->get_result();

$pageTitle = 'Search - MHK Blog';
include __DIR__ . '/../includes/header.php';
?>
<main class="section-pad">
    <div class="container">
        <div class="section-heading" data-animate>
            <span class="eyebrow">Search</span>
            <h1>Find posts fast</h1>
        </div>
        <form class="search-bar mb-4" method="GET" data-animate>
            <input class="form-control form-control-lg" type="search" name="q" value="<?= e($q); ?>" placeholder="Search blog posts">
            <button class="btn btn-dark btn-lg" type="submit">Search</button>
        </form>
        <div class="row g-4">
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
        </div>
    </div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
