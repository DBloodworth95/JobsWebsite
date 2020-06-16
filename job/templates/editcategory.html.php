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

				<h2>Edit Category</h2>
                <?php if(count($errors) > 0): ?>
                    <?php foreach ($errors as $error): ?>
                        <p><?=$error?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if($authorId->accessLevel == 1 || $authorId->accessLevel == 2): ?>
				<form action="" method="POST">

					<input type="hidden" name="category[id]" value="<?php if (isset($_GET['action']) && ($_GET['action'] == 'update')) {
                        echo $categories->id;
                    } ?>"/>
					<label>Name</label>
					<input type="text" name="category[name]" value="<?php if (isset($_GET['action']) && ($_GET['action'] == 'update')) {
                        echo $categories->name;
                    } ?>"/>
					<input type="submit" name="submit" value="Save Category" />
				</form>
        <?php else: ?>
        <p>You do not have access to this page!</p>
        <?php endif; ?>
    </section>
</main>