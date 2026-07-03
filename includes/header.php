<?php
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/functions.php';
startSession();
$pageTitle = $pageTitle ?? 'MHK Blog';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle); ?></title>
    <link rel="stylesheet" href="<?= url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= url('assets/css/style.css'); ?>">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= url(); ?>"><span style="color: #0772ff; font-weight: bold; font-size: 1.5rem;">MHK</span> Blog </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="<?= url(); ?>#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url(); ?>#blog">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url(); ?>#about">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url(); ?>#contact">Contact Us</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (currentUserIsAdmin()): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= url('admin/index.php'); ?>">Dashboard</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="btn btn-outline-dark btn-sm ms-lg-2" href="<?= url('logout.php'); ?>">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="btn btn-dark btn-sm ms-lg-2" href="<?= url('login.php'); ?>">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<?php if ($flash = flash()): ?>
    <div class="container mt-3">
        <div class="alert alert-<?= e($flash['type']); ?> mb-0"><?= e($flash['message']); ?></div>
    </div>
<?php endif; ?>
