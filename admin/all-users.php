<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';
requireSuperAdmin();

$pageTitle = 'Users - MHK Admin';
$users = $conn->query('SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC');

include __DIR__ . '/../includes/head.php';
include __DIR__ . '/navbar.php';
?>
<div class="admin-layout">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="admin-content">
        <?php if ($flash = flash()): ?><div class="alert alert-<?= e($flash['type']); ?>"><?= e($flash['message']); ?></div><?php endif; ?>
        <div class="admin-heading">
            <h1>Users</h1>
            <a href="<?= url('admin/add-user.php'); ?>" class="btn btn-dark">Add User</a>
        </div>
        <div class="content-panel table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Created</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                <?php while ($user = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= e($user['name']); ?></td>
                        <td><?= e($user['email']); ?></td>
                        <td><span class="badge text-bg-dark"><?= e($user['role']); ?></span></td>
                        <td><?= date('M d, Y', strtotime($user['created_at'])); ?></td>
                        <td class="text-end">
                            <a href="<?= url('admin/edit-user.php?id=' . (int) $user['id']); ?>" class="btn btn-sm btn-outline-dark">Edit</a>
                            <?php if ((int) $user['id'] !== (int) $_SESSION['user_id']): ?>
                                <form action="<?= url('admin/delete-user.php'); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                                    <?= csrfField(); ?>
                                    <input type="hidden" name="id" value="<?= (int) $user['id']; ?>">
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
<?php include __DIR__ . '/../includes/footer-script.php'; ?>
