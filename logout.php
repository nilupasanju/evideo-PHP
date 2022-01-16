<?php
session_start();
if (isset($_POST['action']) && $_POST['action'] == 'logout') {
    session_unset();
    session_destroy();
    include 'index.php';
    exit();
}


?>