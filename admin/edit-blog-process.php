<?php 
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../config/config.php');
require_once('../config/connection.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $title = trim($_POST['title']);
    $category_id = intval($_POST['category_id']);
    $content = trim($_POST['content']);

    if(empty($title) || empty($category_id) || empty($content)) {
        $_SESSION['message'] = 'All fields are required.';
        header('Location: edit-blog.php?id=' . $id);
        exit();
    }

    $stmt = $conn->prepare("SELECT image FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $blog = $result->fetch_assoc();
    $stmt->close();

    if(!$blog) {
        $_SESSION['message'] = 'Blog not found.';
        header('Location: manage-blogs.php');
        exit;
    }

    $image_name = $blog['image'];

    if(!isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

        if(!in_array($file_ext, $allowed_exts)) {
            $_SESSION['message'] = 'Invalid image format. Allowed formats: jpg, jpeg, png, gif.';
            header('Location: edit-blog.php?id=' . $id);
            exit;
        }

        $new_image_name = time() . '_' . preg_replace("/[^a-zA-Z0-9.-]/", "_", $file_name);
        $upload_dir = '../uploads/blogs/';
        if(!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        if (move_uploaded_file($file_tmp, $upload_dir . $new_image_name)) {
            if($image_name && file_exists($upload_dir . $image_name)) {
                unlink($upload_dir . $image_name);
            }
            $image_name = $new_image_name;
        }
    }

    $stmt = $conn->prepare("UPDATE posts SET title = ?, category_id = ?, content = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sissi", $title, $category_id, $content, $image_name, $id);

    if($stmt->execute()) {
        $_SESSION['message'] = 'Blog updated successfully!';
    } else {
        $_SESSION['message'] = 'Error updating blog: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header('Location: edit-blog.php?id=' . $id);
    exit;
} else {
    header('Location: manage-blogs.php');
    exit;
}
?>