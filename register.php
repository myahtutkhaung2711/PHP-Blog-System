<?php
require_once __DIR__ . '/config/functions.php';
flash('Public registration is disabled for this portfolio project. Ask an administrator to create accounts.', 'info');
redirect(url('login.php'));
?>
