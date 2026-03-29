<?php
$db = new mysqli("localhost", "root", "", "newsportal");
if ($db->connect_error) {
    die("db connection error: " . $db->connect_error);
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];
    $email = $_POST["email"];
    $user_site = $_POST["user-site"] ?? '';

    if (!preg_match("/^[a-zA-Zа-яА-ЯіІїЇєЄ0-9_-]{4,20}$/u", $login)) {
        $errors["login"] = "Login length must be minimum 4 character without spec symbols";
    }

    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z]).{7,}$/", $password)) {
        $errors["password"] = "Password must contain at least one number, one alphabet, and be at least 8 characters long";
    }

    if ($password !== $repassword) {
        $errors["repassword"] = "Password !== repassword";
    }

    if (!preg_match("/(^[[:alnum:]\.]+)@([\w-]{3,}+\.)([\w-]{2,})(\.[\w-]{2,})?$/", $email)) {
        $errors["email"] = "Incorrect email";
    }

    if ($user_site !== "" && !preg_match("/^https?:\/\/(www\.)?[\w\-]+\.[a-zA-Z]{2,}([\/?=&\w\-.]*)$/", $user_site)) {
        $errors["user-site"] = "Incorrect site name. Name must be like: http://example.com, https://www.example.com";
    }

    if (empty($errors)) {
        $pswd_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare(
            "INSERT INTO users (login, email, password, user_site)
            VALUES(?,?,?,?)"
        );
        $stmt->bind_param("ssss", $login, $email, $pswd_hash, $user_site);

        if ($stmt->execute()) {
            $_SESSION["user_id"] = $stmt->insert_id;
            $_SESSION["login"] = $login;
            $_SESSION["email"] = $email;

            header("Location: index.php?action=registration_successful");
            exit();
        } else {
            $errors["db"] = "db error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$db->close();
?>


<div class="registration-page">
    <div class="registration-field">
        <div class="registration-form">
            <h2>Registration Form</h2>
            <form method="POST">
                <label for="login">Login:</label>
                <input type="text" id="login" name="login" value="<?= $_POST['login'] ?? '' ?>" required />
                <?php if (isset($errors["login"])) echo "<p class='error'>{$errors["login"]}</p>"; ?>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= $_POST["email"] ?? '' ?>" required />
                <?php if (isset($errors["email"])) echo "<p class='error'>{$errors["email"]}</p>"; ?>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required />
                <?php if (isset($errors["password"])) echo "<p class='error'>{$errors["password"]}</p>"; ?>

                <label for="repassword">Re-type Password:</label>
                <input type="password" id="repassword" name="repassword" required />
                <?php if (isset($errors["repassword"])) echo "<p class='error'>{$errors["repassword"]}</p>"; ?>

                <label for="user-site">My web-cite:</label>
                <input type="text" id="user-site" name="user-site" maxlength="255" value="<?= $_POST["user-site"] ?? '' ?>" />
                <?php if (isset($errors["user-site"])) echo "<p class='error'>{$errors["user-site"]}</p>"; ?>

                <button type="submit">
                    register
                </button>
            </form>
        </div>
    </div>
</div>
