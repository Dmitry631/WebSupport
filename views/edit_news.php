<?php
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != 1) {
    die("Access denied");
}

$db = new mysqli("localhost", "root", "", "newsportal");

if ($db->connect_error) {
    die("DB connection error: " . $db->connect_error);
}

$id = (int)($_GET["id"] ?? 0);

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $category = trim($_POST["category"] ?? '');
    $title = trim($_POST["title"] ?? '');
    $description = trim($_POST["description"] ?? '');
    $visible = isset($_POST["visible"]) ? 1 : 0;

    if ($category === "NONE") {
        $errors[] = "Category is required";
    }

    if (empty($title)) {
        $errors[] = "Title is required";
    }

    if (empty($description)) {
        $errors[] = "Description is required";
    }

    if (empty($errors)) {

        $stmt = $db->prepare("
            UPDATE news 
            SET category = ?, title = ?, description = ?, visible = ?
            WHERE id_news = ?
        ");

        $stmt->bind_param("sssii", $category, $title, $description, $visible, $id);
        $stmt->execute();

        header("Location: index.php?action=admin_posts_panel");
        exit();
    }
}

$stmt = $db->prepare("SELECT * FROM news WHERE id_news = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$news = $result->fetch_assoc();

if (!$news) {
    die("News not found");
}
?>

<form method="POST">

    <input type="hidden" name="id" value="<?= $news["id_news"] ?>">

    <label>Category</label>
    <select name="category">
        <?php
        $categories = ["NONE", "smartphones", "laptops", "tech", "OS", "mobile", "development"];

        foreach ($categories as $c):
        ?>
            <option value="<?= $c ?>" <?= $c == $news["category"] ? 'selected' : '' ?>>
                <?= ucfirst($c) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Title</label>
    <input type="text" name="title" value="<?= htmlspecialchars($news["title"]) ?>">

    <label>Description</label>
    <textarea name="description"><?= htmlspecialchars($news["description"]) ?></textarea>

    <input type="checkbox" id="visible" name="visible" value="1" <?= $news["visible"] ? "checked" : "" ?>>
    <label for="visible">Visible</label>


    <button type="submit">Save</button>


</form>
