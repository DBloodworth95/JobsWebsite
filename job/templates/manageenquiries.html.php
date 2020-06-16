<main class="sidebar">

    <section class="left">
        <ul>
            <li><a href="adminjobs">Jobs</a></li>
            <?php if($authorId->accessLevel == 1 || $authorId->accessLevel == 2) { ?>
                <li><a href="admincategories">Categories</a></li>
                <li><a href="enquirymanage">Enquiries</a></li>
            <?php } ?>
            <?php if($authorId->accessLevel == 1) { ?>
                <li><a href="user/add">Add User</a></li>
                <li><a href="user/manage">Manage Users</a></li>
            <?php } ?>

        </ul>
    </section>

    <section class="right">
        <?php if($authorId->accessLevel == 1 || $authorId->accessLevel == 2): ?>
        <a class ="new"><h2>Enquiries</h2></a>

        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th style="width: 15%">Telephone</th>
                <th style="width: 5%">Email</th>
                <th style="width: 5%">Enquiry</th>
                <th style="width: 5%">&nbsp;</th>
                <th style="width: 15%">&nbsp;</th>
                <th style="width: 5%">&nbsp;</th>
                <th style="width: 5%">&nbsp;</th>
            </tr>
            <?php foreach ($enquiries as $enquiry): ?>
            <?php if ($enquiry->responseId == null): ?>
                <tr>
                    <td><?=$enquiry->name;?></td>
                    <td><?=$enquiry->telephone;?></td>
                    <td><?=$enquiry->email?></td>
                    <td><?=$enquiry->enquiry?></td>
                    <td><form method="post" action="">
                            <input type="hidden" name="id" value="<?=$enquiry->id;?>" />
                            <input type="submit" name="submit" value="Mark as complete"/>
                            <input type="hidden" name="name" value="<?=$enquiry->name;?>" />
                            <input type="hidden" name="telephone" value="<?=$enquiry->telephone;?>" />
                            <input type="hidden" name="email" value="<?=$enquiry->email;?>" />
                            <input type="hidden" name="enquiry" value="<?=$enquiry->enquiry;?>" />
                        </form>
                </tr>
            <?php endif; ?>
            <?php endforeach; ?>
            </thead>
        </table>

        <a class ="new"><h2>Completed enquiries</h2></a>

        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th style="width: 15%">Telephone</th>
                <th style="width: 5%">Email</th>
                <th style="width: 5%">Enquiry</th>
                <th style="width: 5%">Completed by</th>
                <th style="width: 5%">&nbsp;</th>
                <th style="width: 15%">&nbsp;</th>
                <th style="width: 5%">&nbsp;</th>
                <th style="width: 5%">&nbsp;</th>
            </tr>

            <?php foreach ($enquiries as $enquiry): ?>
                <?php if ($enquiry->responseId != null): ?>

                <tr>
                    <td><?=$enquiry->name;?></td>
                    <td><?=$enquiry->telephone;?></td>
                    <td><?=$enquiry->email?></td>
                    <td><?=$enquiry->enquiry?></td>
                    <td><?=$enquiry->getResponder()->username; ?></td>
                    <td><form method="post" action="">
                            <input type="hidden" name="id" value="<?=$enquiry->id;?>" />
                            <input type="hidden" name="name" value="<?=$enquiry->name;?>" />
                            <input type="hidden" name="telephone" value="<?=$enquiry->telephone;?>" />
                            <input type="hidden" name="email" value="<?=$enquiry->email;?>" />
                            <input type="hidden" name="enquiry" value="<?=$enquiry->enquiry;?>" />
                        </form>
                </tr>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php else: ?>
                <p>You do not have access to this page!</p>
            <?php endif; ?>
            </thead>
        </table>

    </section>
</main>