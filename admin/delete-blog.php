<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(url('admin/all-blogs.php'));
}

verifyCsrf();
$id = (int) ($_POST['id'] ?? 0);

$stmt = $conn->prepare('SELECT image FROM posts WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$blog = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($blog) {
    $stmt = $conn->prepare('DELETE FROM posts WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    deletePostImage($blog['image']);
    flash('Blog post deleted successfully.', 'success');
} else {
    flash('Blog post not found.', 'warning');
}

redirect(url('admin/all-blogs.php'));
?>
