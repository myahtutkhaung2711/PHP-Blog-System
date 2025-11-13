<?php 
include('../config/connection.php');
include('../includes/session-check.php');
include('../config/constants.php');

if($_SESSION['user_role'] == 'admin'  || $_SESSION['user_role'] == 'superadmin') {
    include('navbar.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>asstes/css/style.css">
</head>
<body>
    <div class="d-flex">
        <?php include('sidebar.php'); ?>
        <div class="flex-grow-1 p-4">
            <div class="container mt-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Admin Dashboard</h4>
                    </div>
                    <div class="card-body">
                        <h5>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h5>
                        <p class="text-muted mb-4">
                            You are logged in as 
                            <strong><?php echo ($_SESSION['user_role'] == 'superadmin') ? 'Super Admin' : 'Admin'; ?></strong>.
                        </p>
        
                        <div class="row text-center">
                            <div class="col-md-3 mb-3">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <h6>Total Blogs</h6>
                                        <h3>12</h3>
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-md-3 mb-3">
                                <div class="card border-success">
                                    <div class="card-body">
                                        <h6>Total Categories</h6>
                                        <h3>4</h3>
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-md-3 mb-3">
                                <div class="card border-warning">
                                    <div class="card-body">
                                        <h6>Total Users</h6>
                                        <h3>3</h3>
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-md-3 mb-3">
                                <div class="card border-danger">
                                    <div class="card-body">
                                        <h6>Pending Comments</h6>
                                        <h3>5</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="mt-4">
                            <a href="all-blogs.php" class="btn btn-outline-primary">Manage Blogs</a>
                            <a href="all-categories.php" class="btn btn-outline-secondary">Manage Categories</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="<?php echo BASE_URL; ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/script.js"></script>
</body>
</html>

<?php
} else {
    echo "<div class='alert alert-danger text-center mt-5'>Access denied.</div>";
}
?>