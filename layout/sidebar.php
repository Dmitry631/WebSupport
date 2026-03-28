</main>
<aside>
    <h3>Navigation</h3>
    <ul>
        <li><a href="index.php?action=main">General</a></li>
        <li><a href="index.php?action=news">News</a></li>
        <li><a href="index.php?action=about">About</a></li>
        <?php if (!isset($_SESSION["login"])): ?>
            <li><a href="index.php?action=login">Log In</a></li>
            <li><a href="index.php?action=registration">Registration</a></li>
        <?php else: ?>
            <li><a href="index.php?action=logout">Log Out</a></li>
        <?php endif; ?>
    </ul>
</aside>
