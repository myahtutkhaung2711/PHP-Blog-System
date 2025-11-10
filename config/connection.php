<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "mhk_blogweb";

    $connect = mysqli_connect($servername, $username, $password, $database);

    if (!$connect) {
        die("Connection failed:" . mysqli_connect_error());
    }
?>