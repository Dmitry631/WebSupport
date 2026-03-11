</main>
<aside>
    <h3>Navigation</h3>
    <ul>
        <li><a href="index.php?action=main">General</a></li>
        <li><a href="index.php?action=news">News</a></li>
        <li><a href="index.php?action=about">About</a></li>
        <?php
        if (!isset($_SESSION["user"])) {
            echo "<li><a href='index.php?action=registration'>Registration</a></li>";
        } else {
            echo "<li><a href='#'>Profile_</a></li>";
        }
        ?>
    </ul>
</aside>
