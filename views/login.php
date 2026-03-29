<?php

$db = new mysqli("localhost", "root", "", "newsportal");
if ($db->connect_error) {
    die("db connection error: " . $db->connect_error);
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $errors["empty-field"] = "Incorrect email or password. Try again.";
    }


    if (empty($errors)) {
        $stmt = $db->prepare("SELECT id_user, login, email, password, admin FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();


        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (empty($user)) {
            $errors["user-notfound"] = "User not found";
        } else {
            $pswd_hash = $user["password"];

            $isVerify = password_verify($password, $pswd_hash);

            if ($isVerify) {
                $_SESSION["user_id"] = $user["id_user"];
                $_SESSION["login"] = $user["login"];
                $_SESSION["email"] = $user["email"];
                $_SESSION["admin"] = $user["admin"];

                header("Location: index.php?action=profile");
                exit();
            } else {
                $errors["incorrect-password"] = "Incorrect password. TRY AGAIN";
            }
        }

        $stmt->close();
    }
}

$db->close();
?>


<div class="login-page">
    <div class="login-field">
        <div class="login-form">
            <h2>Login Form</h2>
            <form method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= $_POST["email"] ?? '' ?>" required />

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required />

                <?php if (isset($errors["empty-field"])) echo "<p class='error'>{$errors["empty-field"]}</p>"; ?>
                <?php if (isset($errors["incorrect-field"])) echo "<p class='error'>{$errors["incorrect-field"]}</p>"; ?>
                <?php if (isset($errors["user-notfound"])) echo "<p class='error'>{$errors["user-notfound"]}</p>"; ?>

                <?php if (!empty($errors)): ?>
                    <?php foreach ($errors as $error): ?>
                        <p class="error"><?= $error ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>

                <button type="submit">Log In</button>

            </form>
        </div>
    </div>
</div>
