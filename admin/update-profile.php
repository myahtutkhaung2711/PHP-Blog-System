<?php
require_once __DIR__ . '/../config/functions.php';
flash('Profile editing is handled from user management.', 'info');
redirect(url('admin/all-users.php'));
?>
