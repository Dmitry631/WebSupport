<?php
$db = new mysqli("localhost", "root", "", "newsportal");
if ($db->connect_error) {
    die("db connection error: " . $db->connect_error);
}

$user_id = $_SESSION["user_id"] ?? null;

if (!$user_id) {
    die("You are not logged in");
}

$stmt = $db->prepare("
    SELECT title, description, category, photo, date 
    FROM news 
    WHERE author_id = ? 
    ORDER BY date DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<h2>My posts</h2>

<?php if ($result->num_rows > 0): ?>

    <?php while ($news = $result->fetch_assoc()): ?>

        <div class="news-item">

            <div class="news-preview">
                <img src="./img/<?= htmlspecialchars($news["photo"]) ?>" alt="News image">
            </div>

            <span class="news-category">
                <?= htmlspecialchars($news["category"]) ?>
            </span>

            <div class="news-text">
                <h3><?= htmlspecialchars($news["title"]) ?></h3>
                <p><?= htmlspecialchars($news["description"]) ?></p>
                <span class="news-date"><?= $news["date"] ?></span>
            </div>

        </div>

    <?php endwhile; ?>

<?php else: ?>

    <p>You have no posts yet</p>

<?php endif; ?>

<?php
$stmt->close();
$db->close();
?>
