<?php 
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../config/functions.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(url('admin/add-blog.php'));
}

verifyCsrf();

$title = trim($_POST['title'] ?? '');
$categoryId = (int) ($_POST['category_id'] ?? 0);
$content = trim($_POST['content'] ?? '');
$status = in_array($_POST['status'] ?? '', ['draft', 'published'], true) ? $_POST['status'] : 'draft';
$userId = (int) ($_SESSION['user_id'] ?? 0);

if ($title === '' || $categoryId <= 0 || $content === '') {
    flash('Title, category, and content are required.', 'danger');
    redirect(url('admin/add-blog.php'));
}

$error = null;
$image = saveUploadedImage($_FILES['image'] ?? [], $error);
if ($error) {
    flash($error, 'danger');
    redirect(url('admin/add-blog.php'));
}

$stmt = $conn->prepare('INSERT INTO posts (user_id, category_id, title, content, image, status) VALUES (?, ?, ?, ?, ?, ?)');
$stmt->bind_param('iissss', $userId, $categoryId, $title, $content, $image, $status);
$stmt->execute();
$stmt->close();

flash('Blog post created successfully.', 'success');
redirect(url('admin/all-blogs.php'));
?>