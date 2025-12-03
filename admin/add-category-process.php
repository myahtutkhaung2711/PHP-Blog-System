<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

require('../config/config.php');
require('../config/connection.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
}

?>