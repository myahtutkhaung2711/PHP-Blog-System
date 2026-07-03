<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';
requireAdmin();

$pageTitle = 'Categories - MHK Admin';
$categories = $conn->query('SELECT categories.*, COUNT(posts.id) AS post_count FROM categories LEFT JOIN posts ON posts.category_id = categories.id GROUP BY categories.id ORDER BY categories.name ASC');

include __DIR__ . '/../includes/head.php';
include __DIR__ . '/navbar.php';
?>
<div class="admin-layout">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="admin-content">
        <?php if ($flash = flash()): ?><div class="alert alert-<?= e($flash['type']); ?>"><?= e($flash['message']); ?></div><?php endif; ?>
        <div class="admin-heading">
            <h1>Categories</h1>
            <a href="<?= url('admin/add-category.php'); ?>" class="btn btn-dark">Add Category</a>
        </div>
        <div class="content-panel table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Name</th><th>Description</th><th>Posts</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                <?php while ($category = $categories->fetch_assoc()): ?>
                    <tr>
                        <td><?= e($category['name']); ?></td>
                        <td><?= e(excerpt($category['description'] ?? '', 90)); ?></td>
                        <td><?= (int) $category['post_count']; ?></td>
                        <td class="text-end">
                            <a href="<?= url('admin/edit-category.php?id=' . (int) $category['id']); ?>" class="btn btn-sm btn-outline-dark">Edit</a>
                            <form action="<?= url('admin/delete-category.php'); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this category? Posts will become uncategorized.')">
                                <?= csrfField(); ?>
                                <input type="hidden" name="id" value="<?= (int) $category['id']; ?>">
                                <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
<?php include __DIR__ . '/../includes/footer-script.php'; ?>
