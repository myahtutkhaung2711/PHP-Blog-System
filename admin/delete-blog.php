<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../config/config.php');
require_once('../config/connection.php');

$blog_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($blog_id <= 0) {
    $_SESSION['message'] = 'Invalid blog ID.';
    header('Location: manage-blogs.php');
    exit;
}

$stmt = $conn->prepare("SELECT image FROM blogs WHERE id = ?");
$stmt->bind_param("i", $blog_id);
$stmt->execute();
$result = $stmt->get_result();
$blog = $result->fetch_assoc();
$stmt->close();

// DELETE BLOG 
$stmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
$stmt->bind_param("i", $blog_id);
if ($stmt->execute()) {
    // Delete image file
    if ($blog['image'] && file_exists('../uploads/blogs/' . $blog['image'])) {
        unlink('../uploads/blogs/' . $blog['image']);
    }
    $_SESSION['message'] = "Blog deleted successfully!";
} else {
    $_SESSION['message'] = "Error deleting blog: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: manage-blogs.php");
exit;
?>