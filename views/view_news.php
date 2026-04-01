<?php

$db = new mysqli("localhost", "root", "", "newsportal");

if ($db->connect_error) {
    die("DB connection error: " . $db->connect_error);
}

$id = (int)($_GET["id"] ?? 0);

if ($id <= 0) {
    die("Invalid ID");
}

$stmt = $db->prepare("
    SELECT id_news, title, description, category, photo, date, visible 
    FROM news 
    WHERE id_news = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$news = $result->fetch_assoc();

if (!$news) {
    die("Такої сторінки не існує");
}

if ((!isset($_SESSION["admin"]) || $_SESSION["admin"] != 1) && $news["visible"] == 0) {
    die("Такої сторінки не існує");
}

?>

<div class="full-news">

    <span class="news-category">
        <?= htmlspecialchars($news["category"]) ?>
    </span>

    <h1><?= htmlspecialchars($news["title"]) ?></h1>

    <span class="news-date">
        <?= $news["date"] ?>
    </span>

    <div class="news-preview">
        <img src="./img/<?= htmlspecialchars($news["photo"]) ?>" alt="News image">
    </div>

    <div class="news-description">
        <?= nl2br(htmlspecialchars($news["description"])) ?>
    </div>

    <br>

    <a href="index.php?action=news">← Back to news</a>

</div>

<?php
$db->close();
?>
