<main class="sidebar">

    <section class="left">
        <ul>
            <li><a href="adminjobs">Jobs</a></li>
            <?php if($authorId->accessLevel == 1 || $authorId->accessLevel == 2): ?>
                <li><a href="admincategories">Categories</a></li>
                <li><a href="enquirymanage">Enquiries</a></li>
            <?php endif; ?>
            <?php if($authorId->accessLevel == 1): ?>
                <li><a href="user/add">Add User</a></li>
                <li><a href="user/manage">Manage Users</a></li>
            <?php endif; ?>
        </ul>
    </section>

    <section class="right">

            <h2>Categories</h2>


            <?php if($authorId->accessLevel == 1 || $authorId->accessLevel == 2): ?>
                <a class="new" href="catedit?action=add">Add new category</a>
            <table>
            <thead>
            <tr>
            <th>Name</th>
            <th style="width: 5%">&nbsp;</th>
            <th style="width: 5%">&nbsp;</th>
            </tr>
            <?php foreach ($categories as $category): ?>
                <tr>
                <td><?=$category->name?></td>
                <td><a style="float: right" href="catedit?id=<?=$category->id?>&action=update">Edit</a></td>
                    <td><form method="post" action="admincategories/delete">
				<input type="hidden" name="category[id]" value="<?=$category->id?>"/>
				<input type="submit" name="submit" value="Delete" />
				</form></td>
                </tr>
            <?php endforeach; ?>
            </thead>
            </table>

            <?php else: ?>
                <p>You do not have access to this page!</p>
            <?php endif; ?>
    </section>
</main>