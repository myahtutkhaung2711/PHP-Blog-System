<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="#">Admin Dashboard</a>
    <div class="text-light">
        <?php if (isset($_SESSION['user_name'])): ?>
            <span>
                (<?php echo $_SESSION['user_name']; ?> 
                <?php echo ($_SESSION['user_role'] == 2) ? '- Super Admin' : '- Admin'; ?>)
            </span>
        <?php endif; ?>
        <a href="../logout.php" class="btn btn-sm btn-danger ms-2">Logout</a>
    </div>
</nav>
