<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(url('admin/all-blogs.php'));
}

verifyCsrf();

$id = (int) ($_POST['id'] ?? 0);
$title = trim($_POST['title'] ?? '');
$categoryId = (int) ($_POST['category_id'] ?? 0);
$content = trim($_POST['content'] ?? '');
$status = in_array($_POST['status'] ?? '', ['draft', 'published'], true) ? $_POST['status'] : 'draft';

if ($id <= 0 || $title === '' || $categoryId <= 0 || $content === '') {
    flash('Title, category, and content are required.', 'danger');
    redirect(url('admin/edit-blog.php?id=' . $id));
}

$stmt = $conn->prepare('SELECT image FROM posts WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$blog = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$blog) {
    flash('Blog post not found.', 'warning');
    redirect(url('admin/all-blogs.php'));
}

$image = $blog['image'];
$error = null;
$newImage = saveUploadedImage($_FILES['image'] ?? [], $error);
if ($error) {
    flash($error, 'danger');
    redirect(url('admin/edit-blog.php?id=' . $id));
}
if ($newImage) {
    deletePostImage($image);
    $image = $newImage;
}

$stmt = $conn->prepare('UPDATE posts SET category_id = ?, title = ?, content = ?, image = ?, status = ? WHERE id = ?');
$stmt->bind_param('issssi', $categoryId, $title, $content, $image, $status, $id);
$stmt->execute();
$stmt->close();

flash('Blog post updated successfully.', 'success');
redirect(url('admin/all-blogs.php'));
?>
