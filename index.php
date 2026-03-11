<?php
session_start();

$action = isset($_GET['action']) ? $_GET['action'] : 'main';
$file = 'views/' . $action . '.php';

if (file_exists($file) && $action !== 'index') {
    $page = $file;
} else {
    $page = 'views/main.php';
}

include 'layout/header.php';

include $page;

include 'layout/sidebar.php';
include 'layout/footer.php';
