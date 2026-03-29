<?php

$db = new mysqli("localhost", "root", "", "newsportal");
if ($db->connect_error) {
    die("db connection error: " . $db->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] = "POST") {
    $login = $_SESSION["login"];
    $email = $_SESSION["email"];
    $user_id = $_SESSION["user_id"];
    $admin = "";

    if (isset($_SESSION["admin"]))
        $admin = $_SESSION["admin"];
}
$db->close();
?>
<h2>Hello: <?php echo $login ?></h2>
<p><br>Email: <?php echo $email ?></p>
<!-- TEMP ID -->
<p><br>ID: <?php echo $user_id ?></p>

<a href="index.php?action=create_post">
    <button class="add-news-btn">
        Create news
    </button>
</a>

<a href="index.php?action=user_posts">
    <button class="show-user-news-btn">
        My news
    </button>
</a>

<?php
if ($admin)
    echo "\nyou are admin, status: " . $admin;
?>
