<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(url('admin/all-categories.php'));
}

verifyCsrf();
$id = (int) ($_POST['id'] ?? 0);
$stmt = $conn->prepare('DELETE FROM categories WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();

flash('Category deleted successfully.', 'success');
redirect(url('admin/all-categories.php'));
?>
