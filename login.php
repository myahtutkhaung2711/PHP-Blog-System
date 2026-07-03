<?php
require_once __DIR__ . '/config/connection.php';
require_once __DIR__ . '/config/functions.php';
startSession();

if (isset($_SESSION['user_id'])) {
    redirect(currentUserIsAdmin() ? url('admin/index.php') : url());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare('SELECT id, name, email, password, role FROM users WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $valid = false;
    if ($user) {
        $valid = password_verify($password, $user['password']);
        if (!$valid && hash_equals($user['password'], md5($password))) {
            $valid = true;
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $update = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');
            $update->bind_param('si', $newHash, $user['id']);
            $update->execute();
            $update->close();
        }
    }

    if ($valid) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        redirect(in_array($user['role'], [ROLE_ADMIN, ROLE_SUPER], true) ? url('admin/index.php') : url());
    }

    flash('Invalid email or password.', 'danger');
    redirect(url('login.php'));
}

$pageTitle = 'Login - MHK Blog';
include __DIR__ . '/includes/header.php';
?>
<main class="auth-wrap">
    <div class="auth-card">
        <h1>Welcome back</h1>
        <p class="text-muted">Sign in to manage your blog account.</p>
        <form method="POST">
            <?= csrfField(); ?>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-dark w-100" type="submit">Login</button>
        </form>
        <p class="small text-muted mt-3 mb-0">Demo admin: admin@gmail.com / 12345</p>
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
