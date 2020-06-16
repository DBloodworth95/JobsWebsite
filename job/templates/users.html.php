<main class="sidebar">

    <section class="left">
        <ul>
            <li><a href="/adminjobs">Jobs</a></li>
            <?php if($authorId->accessLevel == 1 || $authorId->accessLevel == 2): ?>
                <li><a href="/admincategories">Categories</a></li>
            <?php endif; ?>
            <?php if($authorId->accessLevel == 1): ?>
                <li><a href="/user/add">Add User</a></li>
                <li><a href="/user/manage">Manage Users</a></li>
                <li><a href="/enquirymanage">Enquiries</a></li>
            <?php endif; ?>
        </ul>
    </section>
    <section class="right">
        <?php if($authorId->accessLevel == 1): ?>
        <h2>Users</h2>

        <a class="new" href="/user/add?action=add">Add new user</a>

        <table>
        <thead>
        <tr>
        <th style="width: 5%">Username</th>
        <th style="width: 15%">Access Level</th>
        </tr>

        <?php foreach ($users as $user): ?>
            <tr>
            <td><?=$user->username?></td>
            <?php if ($user->accessLevel == 1): ?>
                <td>Owner</td>
            <?php elseif ($user->accessLevel == 2): ?>
                <td>Admin</td>
            <?php elseif ($user->accessLevel == 3): ?>
                <td>Client</td>
            <?php endif; ?>
            <td><a style="float: right" href="/user/add?id=<?=$user->id?>&action=update">Edit</a></td>
            <td><form method="post" action="">
				<input type="hidden" name="user[id]" value="<?=$user->id?>" />
				<input type="submit" name="submit" value="Delete" />
				</form>
				</td>
            </tr>
        <?php endforeach; ?>
        </thead>
        </table>
        <?php else: ?>
            <p>You do not have access to this page!</p>
        <?php endif; ?>
    </section>
</main>