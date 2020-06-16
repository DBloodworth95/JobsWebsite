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
        <?php if($authorId->accessLevel == 1 || $authorId->accessLevel == 2 || $userId == $job->authorId): ?>

                <?php if (isset($_GET['action']) && ($_GET['action'] == 'update')): ?>

                <h2>Edit Job</h2>
                <?php else: ?>
                <h2>Add Job</h2>
                <?php endif; ?>
                <?php if(count($errors) > 0): ?>
                    <?php foreach ($errors as $error): ?>
                        <p><?=$error?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
                <form action="" method="POST">

                    <input type="hidden" name="job[id]" value="<?php if (isset($_GET['action']) && ($_GET['action'] == 'update') && ($userId == $job->authorId || $authorId->accessLevel == 1 || $authorId->accessLevel == 2)) {
                        echo $job->id;
                    } ?>"/>
                    <label>Title</label>
                    <input type="text" name="job[title]" value="<?php if (isset($_GET['action']) && ($_GET['action'] == 'update') && ($userId == $job->authorId || $authorId->accessLevel == 1 || $authorId->accessLevel == 2)) { echo $job->title; }?>" />

                    <label>Description</label>
                    <textarea name="job[description]"><?php if (isset($_GET['action']) && ($_GET['action'] == 'update') && ($userId == $job->authorId || $authorId->accessLevel == 1 || $authorId->accessLevel == 2)) { echo $job->description; }?></textarea>

                    <label>Location</label>
                    <input type="text" name="job[location]" value="<?php if (isset($_GET['action']) && ($_GET['action'] == 'update') && ($userId == $job->authorId || $authorId->accessLevel == 1 || $authorId->accessLevel == 2)) { echo $job->location; }?>" />


                    <label>Salary</label>
                    <input type="text" name="job[salary]" value="<?php if (isset($_GET['action']) && ($_GET['action'] == 'update') && ($userId == $job->authorId || $authorId->accessLevel == 1 || $authorId->accessLevel == 2)) { echo $job->salary; }?>" />

                    <label>Category</label>

                    <select name="job[categoryId]">

                        <?php foreach ($categories as $category) {
                                if (isset($_GET['action']) && ($_GET['action'] == 'update') && $userId == $job->authorId || $authorId->accessLevel == 1 || $authorId->accessLevel == 2) {
                                    echo '<option value="' . $category->id . '">' . $category->name . '</option>';
                                    if ($job->categoryId == $category->id) {
                                        echo '<option selected="selected" value="' . $category->id . '">' . $category->name . '</option>';
                                    }
                                } elseif (isset($_GET['action']) && ($_GET['action'] == 'add')) {
                                        echo '<option value="' . $category->id . '">' . $category->name . '</option>';
                                }
                            }
                        ?>
                    </select>

                    <label>Closing Date</label>
                    <input type="date" name="job[closingDate]" value="<?php if (isset($_GET['action']) && ($_GET['action'] == 'update')) { echo $job->formatDate(); } ?>"  />
                    <input type="submit" name="submit" value="Save" />

                </form>
        <?php else: ?>
            <p>You do not have access to this page!</p>
        <?php endif; ?>
    </section>
</main>