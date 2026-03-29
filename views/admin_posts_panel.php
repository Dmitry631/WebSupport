<?php
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != 1) {
    die("Access denied");
}

$db = new mysqli("localhost", "root", "", "newsportal");

if ($db->connect_error) {
    die("DB connection error: " . $db->connect_error);
}

$all_posts = $db->query("SELECT id_news, author_id, category, title, visible, description, date FROM news ORDER BY date DESC");

?>

<?php if ($all_posts->num_rows > 0): ?>

    <?php while ($news = $all_posts->fetch_assoc()): ?>

        <div class="news-item">
            <span class="news-category">
                <?= htmlspecialchars($news["category"]) ?>
            </span>

            <span class="news-visible">Status: <?= ($news["visible"]) ? "visible" : "hidden"; ?></span>

            <div class="news-text">
                <h3><?= htmlspecialchars($news["title"]) ?></h3>

                <p><?= htmlspecialchars($news["description"]) ?></p>

                <span class="news-author">
                    Author ID: <?= $news["author_id"] ?>
                </span>

                <span class="news-date">
                    <?= $news["date"] ?>
                </span>

                <a href="index.php?action=edit_news&id=<?= $news["id_news"] ?>" class="edit-btn">
                    Edit
                </a>
                <form method="POST" action="index.php?action=delete_news"
                    onsubmit="return confirm('Delete this news?')"
                    style="display:inline;">
                    <input type="hidden" name="delete_id" value="<?= $news["id_news"] ?>">
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
            </div>
        </div>

    <?php endwhile; ?>



<?php else: ?>
    <p>Zero news in DB</p>
<?php endif; ?>

<?php
$db->close();
?>
