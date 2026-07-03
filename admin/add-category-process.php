<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(url('admin/add-category.php'));
}

verifyCsrf();
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');

if ($name === '') {
    flash('Category name is required.', 'danger');
    redirect(url('admin/add-category.php'));
}

$stmt = $conn->prepare('INSERT INTO categories (name, description) VALUES (?, ?)');
$stmt->bind_param('ss', $name, $description);
$stmt->execute();
$stmt->close();

flash('Category created successfully.', 'success');
redirect(url('admin/all-categories.php'));
?>
