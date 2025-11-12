<?php
    function redirect($url) {
        echo "<script>window.location.href='$url';</script>";
        exit();
    }

    function isAdmin() {
        return isset($_SESSION['role']) && ($_SESSION['role'] == ROLE_ADMIN || $_SESSION['role'] == ROLE_SUPER);
    }

    function isSuperAdmin() {
        return isset($_SESSION['role']) && ($_SESSION['role'] == ROLE_SUPER);
    }
?>