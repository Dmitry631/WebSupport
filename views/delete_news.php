<?php
$db = new mysqli("localhost", "root", "", "newsportal");

if ($db->connect_error) {
    die("db connection error: " . $db->connect_error);
}

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != 1) {
    die("Access denied");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_id"])) {

    $id = (int)$_POST["delete_id"];

    $stmt = $db->prepare("DELETE FROM news WHERE id_news = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo "real delete";

    header("Location: index.php?action=admin_posts_panel");
    exit();
}
