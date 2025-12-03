<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../config/config.php');
require_once('../config/connection.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get and sanitize form inputs
    $title = trim($_POST['title']);
    $category_id = intval($_POST['category_id']);
    $content = trim($_POST['content']);

    // Validate required fields
    if (empty($title) || empty($category_id) || empty($content)) {
        $_SESSION['message'] = "Please fill out all required fields.";
        header("Location: add-blog.php");
        exit;
    }

    // Handle image upload if exists
    $image_name = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = basename($_FILES['image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($file_ext, $allowed_ext)) {
            $_SESSION['message'] = "Only JPG, JPEG, PNG, GIF images are allowed.";
            header("Location: add-blog.php");
            exit;
        }

        // Rename the file to prevent conflicts
        $new_name = time() . '_' . preg_replace("/[^a-zA-Z0-9.-]/", "_", $file_name);

        // Upload folder path
        $upload_dir = '../uploads/blogs/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Move the uploaded file
        if (!move_uploaded_file($file_tmp, $upload_dir . $new_name)) {
            $_SESSION['message'] = "Failed to upload image.";
            header("Location: add-blog.php");
            exit;
        }

        // Store relative path in database (so database has blogs/filename)
        $image_name = 'blogs/' . $new_name;
    }

    // Insert blog into database
    $stmt = $conn->prepare("INSERT INTO posts (title, category_id, content, image, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("siss", $title, $category_id, $content, $image_name);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Blog created successfully!";
    } else {
        $_SESSION['message'] = "Error creating blog: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: add-blog.php");
    exit;

} else {
    // Redirect if accessed directly
    header("Location: add-blog.php");
    exit;
}
