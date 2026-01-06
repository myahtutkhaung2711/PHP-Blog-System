<?php
// Start session and include config
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../config/config.php');
require_once('../config/connection.php');

include('../includes/head.php');

// Fetch all users 
$users = $conn->query("
    SELECT * FROM users ORDER BY name ASC
");

// Separate by role 
$superadmins = [];
$admins = [];
$customers = [];

while($row = $users->fetch_assoc()) {
    if ($row['role'] === 'superadmin') {
        $superadmins[] = $row;
    } elseif ($row['role'] === 'admin') {
        $admins[] = $row;
    } else {
        $customers[] = $row;
    }
}
?>

<?php  include('navbar.php'); ?>

<div class="d-flex">
    <?php include('sidebar.php') ?>

    <div class="container-fluid mt-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>All Users</h2>
            <a href="add-user.php" class="btn btn-outline-success"> Add New User </a>
        </div>

        <!-- Superadmin User -->
        <h4 class="text-danger mb-3">
            Super Admins
        </h4>

        <div class="row">
            <?php foreach ($superadmins as $user) : ?>
                <div class="col-md-4 mb-3">
                    <div class="card border-danger shadow-sm">
                        <div class="card-body">
                            <h5><?= htmlspecialchars($user['name']); ?></h5>
                            <p class="mb-1"><?= htmlspecialchars($user['email']); ?></p>
                            <span class="badge bg-danger">Super Admin</span>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


        <!-- Admin User -->
        <h4 class="text-primary mt-4 mb-3">
            Admin Users
        </h4>

        <div class="row">
            <?php foreach ($admins as $user) : ?>
                <div class="col-md-4 mb-3">
                    <div class="card border-primary shadow-sm">
                        <div class="card-body">
                            <h5><?= htmlspecialchars($user['name']); ?></h5>
                            <p class="mb-1"><?= htmlspecialchars($user['email']); ?></p>
                            <span class="badge bg-primary">Admin</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


        <!-- Customer User -->
        <h4 class="text-success mt-4 mb-3">
            Customers
        </h4>

        <div class="row">
            <?php foreach ($customers as $user) : ?>
                <div class="col-md-4 mb-3">
                    <div class="card border-success shadow-sm">
                        <div class="card-body">
                            <h5><?= htmlspecialchars($user['name']); ?></h5>
                            <p class="mb-1"><?= htmlspecialchars($user['email']); ?></p>
                            <span class="badge bg-success">Customer</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


    </div>
</div>

<?php include('../includes/footer-script.php') ?>