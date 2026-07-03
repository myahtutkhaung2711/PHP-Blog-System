<?php startSession(); ?>
<nav class="navbar navbar-expand-lg navbar-dark admin-navbar px-3">
    <a class="navbar-brand fw-bold" href="<?= url('admin/index.php'); ?>"><span style="color: #0772ff; font-weight: bold; font-size: 1.5rem;">MHK</span> Blog / Admin</a>
    <div class="ms-auto d-flex align-items-center gap-2 text-light">
        <span class="small d-none d-md-inline"><?= e($_SESSION['user_name'] ?? 'Admin'); ?> (<?= e($_SESSION['user_role'] ?? ''); ?>)</span>
        <a href="<?= url(); ?>" class="btn btn-sm btn-outline-light">View Site</a>
        <a href="<?= url('logout.php'); ?>" class="btn btn-sm btn-light">Logout</a>
    </div>
</nav>


