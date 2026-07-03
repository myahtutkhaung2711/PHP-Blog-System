<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';
requireAdmin();

$pageTitle = 'Blog Posts - MHK Admin';
$blogs = $conn->query("
    SELECT posts.*, categories.name AS category_name, users.name AS author_name
    FROM posts
    LEFT JOIN categories ON posts.category_id = categories.id
    LEFT JOIN users ON posts.user_id = users.id
    ORDER BY posts.created_at DESC, posts.id DESC
");

include __DIR__ . '/../includes/head.php';
include __DIR__ . '/navbar.php';
?>
<div class="admin-layout">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="admin-content">
        <?php if ($flash = flash()): ?><div class="alert alert-<?= e($flash['type']); ?>"><?= e($flash['message']); ?></div><?php endif; ?>
        <div class="admin-heading">
            <h1>Blog Posts</h1>
            <a href="<?= url('admin/add-blog.php'); ?>" class="btn btn-dark">Create New Post</a>
        </div>
        <div class="content-panel table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Title</th><th>Category</th><th>Author</th><th>Status</th><th>Created</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                <?php if ($blogs->num_rows > 0): ?>
                    <?php while ($blog = $blogs->fetch_assoc()): ?>
                        <tr>
                            <td><?= e($blog['title']); ?></td>
                            <td><?= e($blog['category_name'] ?? 'Uncategorized'); ?></td>
                            <td><?= e($blog['author_name'] ?? 'Admin'); ?></td>
                            <td><span class="badge text-bg-<?= $blog['status'] === 'published' ? 'success' : 'secondary'; ?>"><?= e($blog['status']); ?></span></td>
                            <td><?= date('M d, Y', strtotime($blog['created_at'])); ?></td>
                            <td class="text-end">
                                <a href="<?= url('admin/edit-blog.php?id=' . (int) $blog['id']); ?>" class="btn btn-sm btn-outline-dark">Edit</a>
                                <form action="<?= url('admin/delete-blog.php'); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this blog post?')">
                                    <?= csrfField(); ?>
                                    <input type="hidden" name="id" value="<?= (int) $blog['id']; ?>">
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center text-muted">No blog posts found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
<?php include __DIR__ . '/../includes/footer-script.php'; ?>
