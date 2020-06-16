<main class="sidebar">
        <h2>Log in</h2>
    <?php if (isset($error)): ?>
        <div class="errors"><?=$error?></div>
        <?php endif; ?>
        <form action="/login" method="post" style="padding: 40px">
            <label>Enter Username</label>
            <input type="text" name="username" />
            <label>Enter Password</label>
            <input type="password" name="password" />
            <input type="submit" name="submit" value="Log In" />
        </form>
</main>
