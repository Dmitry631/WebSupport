<?php
$db = new mysqli("localhost", "root", "", "newsportal");
if ($db->connect_error) {
    die("db connection error: " . $db->connect_error);
}

$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = trim($_POST["category"] ?? '');
    $title = trim($_POST["title"] ?? '');
    $description = trim($_POST["description"] ?? '');

    if ($category === "NONE") {
        $errors["category"] = "Category is required";
    }

    if (empty($title)) {
        $errors["title"] = "Title is required";
    } elseif (strlen($title) < 3) {
        $errors["title"] = "Title is too short";
    }

    if (empty($description)) {
        $errors["description"] = "Description is required";
    }

    if (empty($errors)) {
        $author_id = $_SESSION["user_id"];

        if ($_SESSION["admin"] == 1)
            $visible = 1;
        else
            $visible = 0;

        $stmt = $db->prepare("
            INSERT INTO news (author_id, category, title, description, visible)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->bind_param("isssi", $author_id, $category, $title, $description, $visible);

        if ($stmt->execute()) {
            header("Location: index.php?action=news");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>


<div class="add-news-page">
    <form method="POST" class="add-news-form">

        <div class=add-news-form-columns>
            <div class="add-news-left">
                <label>Select category</label>
                <?php
                $categories = ["NONE", "smartphones", "laptops", "tech", "OS", "mobile", "development"];

                echo '<select name="category">';
                foreach ($categories as $c) {
                    echo '<option value="' . $c . '">' . ucfirst($c) . '</option>';
                }
                echo '</select>';
                ?>
                <label>Title</label>
                <input type="text" name="title">

                <label>Description</label>
                <textarea name="description"></textarea>
            </div>

            <div class="add-news-right">
                <label>Preview photo</label>
                <input type="file" name="photo">
            </div>
        </div>

        <button type="submit">Post</button>

    </form>
</div>
