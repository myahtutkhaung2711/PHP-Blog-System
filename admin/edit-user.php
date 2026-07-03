<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';
requireSuperAdmin();

$id = max(0, (int) ($_GET['id'] ?? 0));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = in_array($_POST['role'] ?? '', [ROLE_USER, ROLE_ADMIN, ROLE_SUPER], true) ? $_POST['role'] : ROLE_USER;
    $password = $_POST['password'] ?? '';

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash('Please enter a valid name and email.', 'danger');
        redirect(url('admin/edit-user.php?id=' . $id));
    }

    if ($password !== '') {
        if (strlen($password) < 6) {
            flash('Password must be at least 6 characters.', 'danger');
            redirect(url('admin/edit-user.php?id=' . $id));
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('UPDATE users SET name = ?, email = ?, role = ?, password = ? WHERE id = ?');
        $stmt->bind_param('ssssi', $name, $email, $role, $hash, $id);
    } else {
        $stmt = $conn->prepare('UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?');
        $stmt->bind_param('sssi', $name, $email, $role, $id);
    }
    $stmt->execute();
    $stmt->close();
    flash('User updated successfully.', 'success');
    redirect(url('admin/all-users.php'));
}

$stmt = $conn->prepare('SELECT id, name, email, role FROM users WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    flash('User not found.', 'warning');
    redirect(url('admin/all-users.php'));
}

$pageTitle = 'Edit User - MHK Admin';
include __DIR__ . '/../includes/head.php';
include __DIR__ . '/navbar.php';
?>
<div class="admin-layout">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="admin-content">
        <?php if ($flash = flash()): ?><div class="alert alert-<?= e($flash['type']); ?>"><?= e($flash['message']); ?></div><?php endif; ?>
        <div class="admin-heading"><h1>Edit User</h1></div>
        <form class="content-panel" method="POST">
            <?= csrfField(); ?>
            <div class="mb-3"><label class="form-label">Name</label><input class="form-control" name="name" value="<?= e($user['name']); ?>" required maxlength="100"></div>
            <div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="<?= e($user['email']); ?>" required maxlength="100"></div>
            <div class="mb-3"><label class="form-label">New Password</label><input class="form-control" type="password" name="password" minlength="6" placeholder="Leave blank to keep current password"></div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select class="form-select" name="role">
                    <?php foreach ([ROLE_USER => 'User', ROLE_ADMIN => 'Admin', ROLE_SUPER => 'Super Admin'] as $value => $label): ?>
                        <option value="<?= e($value); ?>" <?= $user['role'] === $value ? 'selected' : ''; ?>><?= e($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="btn btn-dark" type="submit">Update User</button>
        </form>
    </main>
</div>
<?php include __DIR__ . '/../includes/footer-script.php'; ?>
