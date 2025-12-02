<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../config/config.php');
require_once('../config/connection.php');
include('../includes/head.php');
include('navbar.php');

$blog_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($blog_id <= 0 ) {
    $_SESSION['message'] = 'Invalid blog ID.';
    header('Location: manage-blogs.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $blog_id);
$stmt->execute();
$result = $stmt->get_result();
$blog = $result->fetch_assoc();
$stmt->close();

if(!$blog) {
    $_SESSION['message'] = 'Blog not found.';
    header('Location: manage-blogs.php');
    exit;
}

$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");
?>

<div class="d-flex">
    <?php include('sidebar.php') ?>

    <div class="container-fluid p-4">
        <h1 class="mb-3">Edit Blog</h1>
        <hr>

        <?php 
        if(isset($_SESSION['message'])) {
            echo '<div class="alert alert-info">'.$_SESSION['message'].' </div>';
            unset($_SESSION['message']);
        }
        ?>

        <div class="card-shadow sm">
            <div class="card-body">
                <form action="edit-blog-process.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $blog['id']; ?>">

                    <div class="mb-3">
                        <label class="form-label">Blog Title</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($blog['title']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            <?php while($cate = $categories->fetch_assoc()) { ?>
                                <option value="<?= $cate['id'] ?>" <?= $cate['id'] == $blog['category_id'] ? 'selectd' : ''; ?>>
                                    <?= htmlspecialchars($cate['name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fetured Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <?php if($blog['image'])  { ?> 
                            <img src="../uploads/blogs/<?= $blog['image']; ?>" alt="" style="height:80px;margin-top:10px;">
                        <?php } ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content</label>'
                        <textarea name="content" class="form-control" rows="6" required><?= htmlspecialchars($blog['content']); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-outline-dark">Update Blog Post</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer-script.php'); ?>
