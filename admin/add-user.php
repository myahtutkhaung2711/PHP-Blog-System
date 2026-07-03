<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';
requireSuperAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = in_array($_POST['role'] ?? '', [ROLE_USER, ROLE_ADMIN, ROLE_SUPER], true) ? $_POST['role'] : ROLE_USER;

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        flash('Please enter a valid name, email, and password with at least 6 characters.', 'danger');
        redirect(url('admin/add-user.php'));
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssss', $name, $email, $hash, $role);
    if (!$stmt->execute()) {
        flash('Could not create user. The email may already exist.', 'danger');
        redirect(url('admin/add-user.php'));
    }
    $stmt->close();
    flash('User created successfully.', 'success');
    redirect(url('admin/all-users.php'));
}

$pageTitle = 'Add User - MHK Admin';
include __DIR__ . '/../includes/head.php';
include __DIR__ . '/navbar.php';
?>
<div class="admin-layout">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="admin-content">
        <?php if ($flash = flash()): ?><div class="alert alert-<?= e($flash['type']); ?>"><?= e($flash['message']); ?></div><?php endif; ?>
        <div class="admin-heading"><h1>Add User</h1></div>
        <form class="content-panel" method="POST">
            <?= csrfField(); ?>
            <div class="mb-3"><label class="form-label">Name</label><input class="form-control" name="name" required maxlength="100"></div>
            <div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" required maxlength="100"></div>
            <div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required minlength="6"></div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select class="form-select" name="role">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="superadmin">Super Admin</option>
                </select>
            </div>
            <button class="btn btn-dark" type="submit">Create User</button>
        </form>
    </main>
</div>
<?php include __DIR__ . '/../includes/footer-script.php'; ?>
