<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';
requireAdmin();

$pageTitle = 'Create Blog Post - MHK Admin';
$categories = $conn->query('SELECT * FROM categories ORDER BY name ASC');

include __DIR__ . '/../includes/head.php';
include __DIR__ . '/navbar.php';
?>
<div class="admin-layout">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="admin-content">
        <?php if ($flash = flash()): ?><div class="alert alert-<?= e($flash['type']); ?>"><?= e($flash['message']); ?></div><?php endif; ?>
        <div class="admin-heading"><h1>Create Blog Post</h1></div>
        <form class="content-panel" action="<?= url('admin/add-blog-process.php'); ?>" method="POST" enctype="multipart/form-data">
            <?= csrfField(); ?>
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required maxlength="255">
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Select category</option>
                        <?php while ($cat = $categories->fetch_assoc()): ?>
                            <option value="<?= (int) $cat['id']; ?>"><?= e($cat['name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <label class="form-label">Featured Image</label>
                <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp">
            </div>
            <div class="mt-3">
                <label class="form-label">Content</label>
                <textarea name="content" rows="10" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-dark mt-4">Create Post</button>
        </form>
    </main>
</div>
<?php include __DIR__ . '/../includes/footer-script.php'; ?>
