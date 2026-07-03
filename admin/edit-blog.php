<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';
requireAdmin();

$id = max(0, (int) ($_GET['id'] ?? 0));
$stmt = $conn->prepare('SELECT * FROM posts WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$blog = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$blog) {
    flash('Blog post not found.', 'warning');
    redirect(url('admin/all-blogs.php'));
}

$pageTitle = 'Edit Blog Post - MHK Admin';
$categories = $conn->query('SELECT * FROM categories ORDER BY name ASC');

include __DIR__ . '/../includes/head.php';
include __DIR__ . '/navbar.php';
?>
<div class="admin-layout">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="admin-content">
        <?php if ($flash = flash()): ?><div class="alert alert-<?= e($flash['type']); ?>"><?= e($flash['message']); ?></div><?php endif; ?>
        <div class="admin-heading"><h1>Edit Blog Post</h1></div>
        <form class="content-panel" action="<?= url('admin/edit-blog-process.php'); ?>" method="POST" enctype="multipart/form-data">
            <?= csrfField(); ?>
            <input type="hidden" name="id" value="<?= (int) $blog['id']; ?>">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="<?= e($blog['title']); ?>" required maxlength="255">
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <?php while ($cat = $categories->fetch_assoc()): ?>
                            <option value="<?= (int) $cat['id']; ?>" <?= (int) $cat['id'] === (int) $blog['category_id'] ? 'selected' : ''; ?>><?= e($cat['name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="published" <?= $blog['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                        <option value="draft" <?= $blog['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <label class="form-label">Featured Image</label>
                <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp">
                <?php if ($blog['image']): ?>
                    <img class="admin-thumb mt-2" src="<?= e(postImageUrl($blog['image'])); ?>" alt="<?= e($blog['title']); ?>">
                <?php endif; ?>
            </div>
            <div class="mt-3">
                <label class="form-label">Content</label>
                <textarea name="content" rows="10" class="form-control" required><?= e($blog['content']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-dark mt-4">Update Post</button>
        </form>
    </main>
</div>
<?php include __DIR__ . '/../includes/footer-script.php'; ?>
