<?php
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/functions.php';
startSession();
$pageTitle = $pageTitle ?? 'MHK Blog Admin';
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
<body class="admin-body">
