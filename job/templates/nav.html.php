<nav>
    <ul>
        <li><a href="/">Home</a></li>
        <li>Jobs
            <ul>
                <?php foreach($categories as $category): ?>
                    <blockquote>
                        <li><a href="/jobs/?id=<?=$category->id?>"><?=$category->name?></a></li>
                    </blockquote>
                <?php endforeach; ?>
            </ul>
        </li>
        <li><a href="/faq">FAQ</a></li>
        <li><a href="/about">About Us</a></li>
        <?php if ($loggedIn): ?>
        <li><a href="/logout">Logout</a></li>
        <?php else: ?>
        <li><a href="/login">Login</a></li>
        <?php endif; ?>
    </ul>

</nav>