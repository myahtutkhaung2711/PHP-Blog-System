<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';
requireAdmin();

$pageTitle = 'Admin Dashboard - MHK Blog';
$stats = [
    'posts' => (int) $conn->query('SELECT COUNT(*) AS total FROM posts')->fetch_assoc()['total'],
    'categories' => (int) $conn->query('SELECT COUNT(*) AS total FROM categories')->fetch_assoc()['total'],
    'messages' => (int) $conn->query('SELECT COUNT(*) AS total FROM contact_messages WHERE is_read = 0')->fetch_assoc()['total'],
    'users' => (int) $conn->query('SELECT COUNT(*) AS total FROM users')->fetch_assoc()['total'],
];
$recentPosts = $conn->query('SELECT title, status, created_at FROM posts ORDER BY created_at DESC LIMIT 5');

include __DIR__ . '/../includes/head.php';
include __DIR__ . '/navbar.php';
?>
<div class="admin-layout">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="admin-content">
        <?php if ($flash = flash()): ?><div class="alert alert-<?= e($flash['type']); ?>"><?= e($flash['message']); ?></div><?php endif; ?>
        <div class="admin-heading">
            <div>
                <span class="eyebrow">Dashboard</span>
                <h1>Welcome, <?= e($_SESSION['user_name']); ?></h1>
            </div>
            <a class="btn btn-dark" href="<?= url('admin/add-blog.php'); ?>">Create Post</a>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3"><div class="stat-card"><span>Posts</span><strong><?= $stats['posts']; ?></strong></div></div>
            <div class="col-sm-6 col-xl-3"><div class="stat-card"><span>Categories</span><strong><?= $stats['categories']; ?></strong></div></div>
            <div class="col-sm-6 col-xl-3"><div class="stat-card"><span>Unread Messages</span><strong><?= $stats['messages']; ?></strong></div></div>
            <div class="col-sm-6 col-xl-3"><div class="stat-card"><span>Users</span><strong><?= $stats['users']; ?></strong></div></div>
        </div>

        <div class="content-panel">
            <h2 class="h5 mb-3">Recent Posts</h2>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Title</th><th>Status</th><th>Created</th></tr></thead>
                    <tbody>
                        <?php while ($post = $recentPosts->fetch_assoc()): ?>
                            <tr>
                                <td><?= e($post['title']); ?></td>
                                <td><span class="badge text-bg-<?= $post['status'] === 'published' ? 'success' : 'secondary'; ?>"><?= e($post['status']); ?></span></td>
                                <td><?= date('M d, Y', strtotime($post['created_at'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<?php include __DIR__ . '/../includes/footer-script.php'; ?>
