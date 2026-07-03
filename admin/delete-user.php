<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';
requireSuperAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(url('admin/all-users.php'));
}

verifyCsrf();
$id = (int) ($_POST['id'] ?? 0);
if ($id === (int) $_SESSION['user_id']) {
    flash('You cannot delete your own account.', 'danger');
    redirect(url('admin/all-users.php'));
}

$stmt = $conn->prepare('DELETE FROM users WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();

flash('User deleted successfully.', 'success');
redirect(url('admin/all-users.php'));
?>
