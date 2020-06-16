<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/styles.css"/>
    <title><?=$title?></title>
</head>
<body>
<header>
    <section>
        <aside>
            <h3>Office Hours:</h3>
            <p>Mon-Fri: 09:00-17:30</p>
            <p>Sat: 09:00-17:00</p>
            <p>Sun: Closed</p>
        </aside>
        <h1>Jo's Jobs</h1>

    </section>
</header>
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
            <li><a href="/enquiry">Ask a question</a></li>
            <?php if ($loggedIn): ?>
                <li><a href="/logout">Logout</a></li>
                <li><a href="/adminjobs">Manage jobs</a></li>
            <?php else: ?>
                <li><a href="/login">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
<img src="images/randombanner.php"/>
<?=$output?>
</main>

<footer>
    &copy; Jo's Jobs <?php $date = new DateTime();
    $date = $date->format('Y');
    echo $date ?>
</footer>
</body>
</html>
