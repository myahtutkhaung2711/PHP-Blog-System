<?php
require_once __DIR__ . '/config/functions.php';
startSession();
$_SESSION = [];
session_destroy();
redirect(url('login.php'));
?>
