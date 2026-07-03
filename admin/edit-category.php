<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';
requireAdmin();

$id = max(0, (int) ($_GET['id'] ?? 0));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    if ($name === '') {
        flash('Category name is required.', 'danger');
        redirect(url('admin/edit-category.php?id=' . $id));
    }
    $stmt = $conn->prepare('UPDATE categories SET name = ?, description = ? WHERE id = ?');
    $stmt->bind_param('ssi', $name, $description, $id);
    $stmt->execute();
    $stmt->close();
    flash('Category updated successfully.', 'success');
    redirect(url('admin/all-categories.php'));
}

$stmt = $conn->prepare('SELECT * FROM categories WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$category = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$category) {
    flash('Category not found.', 'warning');
    redirect(url('admin/all-categories.php'));
}

$pageTitle = 'Edit Category - MHK Admin';
include __DIR__ . '/../includes/head.php';
include __DIR__ . '/navbar.php';
?>
<div class="admin-layout">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="admin-content">
        <?php if ($flash = flash()): ?><div class="alert alert-<?= e($flash['type']); ?>"><?= e($flash['message']); ?></div><?php endif; ?>
        <div class="admin-heading"><h1>Edit Category</h1></div>
        <form class="content-panel" action="<?= url('admin/edit-category.php?id=' . (int) $category['id']); ?>" method="POST">
            <?= csrfField(); ?>
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="<?= e($category['name']); ?>" required maxlength="100">
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" rows="5" class="form-control"><?= e($category['description']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-dark">Update Category</button>
        </form>
    </main>
</div>
<?php include __DIR__ . '/../includes/footer-script.php'; ?>
