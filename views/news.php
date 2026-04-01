<h2>Latest news</h2>

<?php
$db = new mysqli("localhost", "root", "", "newsportal");
if ($db->connect_error) {
    die("db connection error: " . $db->connect_error);
}
if ($_SESSION["admin"])
    $stmt = $db->prepare("SELECT id_news, title, description, category, photo, date FROM news ORDER BY date DESC");
else
    $stmt = $db->prepare("SELECT id_news, title, description, category, photo, date FROM news WHERE visible = 1 ORDER BY date DESC");

$stmt->execute();

$result = $stmt->get_result();

?>

<?php while ($news = $result->fetch_assoc()): ?>
    <a href="index.php?action=view_news&id=<?= $news["id_news"] ?>" class="news-link">
        <div class="news-item">
            <div class="news-preview">
                <img src="./img/<?= htmlspecialchars($news["photo"]) ?>" alt="News image">
            </div>
            <span class="news-category">
                <?= htmlspecialchars($news["category"]) ?>
            </span>
            <div class="news-text">
                <h3><?= htmlspecialchars($news["title"]) ?></h3>
                <p>
                    <?= htmlspecialchars(mb_strimwidth($news["description"], 0, 100, "...")) ?>
                </p>
                <span class="news-date">
                    <?= $news["date"] ?>
                </span>
            </div>
        </div>
    </a>
<?php endwhile; ?>


<div class="news-item">
    <div class="news-preview">
        <img src="./img/news3.jpg" alt="S26 Ultra">
    </div>
    <span class="news-category">Smartphones</span>

    <div class="news-text">
        <h3>Samsung S26 Ultra</h3>
        <p>Samsung's new flagship, the Galaxy S26 Ultra, does not disappoint.</p>
        <span class="news-date"> February 25, 2026</span>
    </div>
</div>

<div class="news-item">
    <div class="news-preview">
        <img src="./img/news1.jpg" alt="Iphone 17e">
    </div>

    <span class="news-category">Smartphones</span>

    <div class="news-text">

        <h3>Iphone 17e</h3>
        <p>Apple today announced the new iPhone 17e</p>
        <span class="news-date"> March 03, 2026</span>
    </div>

</div>

<div class="news-item">
    <div class="news-preview">
        <img src="./img/news2.jpg" alt="MacBook Neo">
    </div>

    <span class="news-category">Laptops</span>

    <div class="news-text">

        <h3>New MacBook NEO</h3>
        <p>Apple's new MacBook Neo gives the company its cheapest laptop ever, creating a budget entry into the Mac lineup</p>
        <span class="news-date"> March 04, 2026</span>
    </div>
</div>
