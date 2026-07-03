<aside class="admin-sidebar">
    <div class="sidebar-title">Menu</div>
    <a href="<?= url('admin/index.php'); ?>">Dashboard</a>
    <a href="<?= url('admin/all-blogs.php'); ?>">Blog Posts</a>
    <a href="<?= url('admin/add-blog.php'); ?>">Create Post</a>
    <a href="<?= url('admin/all-categories.php'); ?>">Categories</a>
    <a href="<?= url('admin/messages.php'); ?>">Messages</a>
    <?php if (currentUserIsSuperAdmin()): ?>
        <a href="<?= url('admin/all-users.php'); ?>">Users</a>
        <a href="<?= url('admin/add-user.php'); ?>">Add User</a>
    <?php endif; ?>
</aside>
