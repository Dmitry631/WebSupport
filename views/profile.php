<?php

$db = new mysqli("localhost", "root", "", "newsportal");
if ($db->connect_error) {
    die("db connection error: " . $db->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] = "POST") {
    $login = $_SESSION["login"];
    $email = $_SESSION["email"];
    $admin = $_SESSION["admin"];
}

?>
<h2>Hello: <?php echo $login ?></h2>
<p><br>Email: <?php echo $email ?></p>
<?php
echo "\nyou are admin, status: " . $admin;
?>
