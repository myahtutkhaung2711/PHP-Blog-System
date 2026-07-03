<?php
if (!defined('BASE_URL')) {
    $scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $basePath = preg_replace('#/(admin|pages|config|includes)$#', '', rtrim($scriptName, '/'));
    define('BASE_URL', ($basePath === '' ? '' : $basePath) . '/');
}

if (!defined('ROLE_USER')) {
    define('ROLE_USER', 'user');
}
if (!defined('ROLE_ADMIN')) {
    define('ROLE_ADMIN', 'admin');
}
if (!defined('ROLE_SUPER')) {
    define('ROLE_SUPER', 'superadmin');
}

if (!defined('MAX_UPLOAD_BYTES')) {
    define('MAX_UPLOAD_BYTES', 2 * 1024 * 1024);
}
?>
