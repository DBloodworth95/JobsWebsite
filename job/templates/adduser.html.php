<main class="sidebar" xmlns="http://www.w3.org/1999/html">

    <section class="left">
        <ul>

            <?php if($authorId->accessLevel == 1 || $authorId->accessLevel == 2): ?>
                <li><a href="/adminjobs">Jobs</a></li>
                <li><a href="/admincategories">Categories</a></li>
                <li><a href="/enquirymanage">Enquiries</a></li>
            <?php endif; ?>
            <?php if($authorId->accessLevel == 1): ?>
                <li><a href="/user/add">Add User</a></li>
                <li><a href="/user/manage">Manage Users</a></li>
            <?php endif; ?>

        </ul>
    </section>

    <section class="right">
        <h2>Add User</h2>
        <?php if(count($errors) > 0): ?>
            <?php foreach ($errors as $error): ?>
                <p><?=$error?></p>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if($authorId->accessLevel == 1): ?>
        <form action="" method="post">
            <label>Username</label>

            <input type="hidden" name="user[id]" value="<?php if (isset($_GET['action']) && ($_GET['action'] == 'update')) {
                echo $user->id;
            } ?>"/>

            <input type="text" name="user[username]" value="<?php if (isset($_GET['action']) && ($_GET['action'] == 'update')) {
                echo $user->username;
            } ?>"/>
            <label>Password</label>
            <input type="password" name="user[password]" />
            <select name="user[accessLevel]">
                <option value="1">Owner</option>
                <option value="2">Admin</option>
                <option value="3">Client</option>
            </select>
            <input type="submit" name="submit" value="Create/Save" />
        </form>
        <?php else: ?>
            <p>You do not have access to this page!</p>
        <?php endif; ?>
    </section>
</main>