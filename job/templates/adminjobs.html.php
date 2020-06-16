<main class="sidebar">

    <section class="left">
        <ul>
            <li><a href="adminjobs">Jobs</a></li>
            <?php if($authorId->accessLevel == 1 || $authorId->accessLevel == 2): ?>
            <li><a href="admincategories">Categories</a></li>
                <li><a href="enquirymanage">Enquiries</a></li>
            <?php endif; ?>
            <?php if($authorId->accessLevel == 1):?>
            <li><a href="user/add">Add User</a></li>
                <li><a href="user/manage">Manage Users</a></li>
            <?php endif; ?>
        </ul>
    </section>
    <section class="right">

            <h2>Jobs</h2>

            <a class="new" href="jobedit?action=add">Add new job</a>

            <h2>Filter by Category</h2>
            <form method="post" action="">
            <select name="categoryType">
                <?php foreach ($categories as $category): ?>
                    <option value="<?=$category->id?>"><?=$category->name?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" name="sortJob" value="Show"/>
            </form>


                <table>
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th style="width: 10%">Salary</th>
                        <th style="width: 5%">Category</th>
                        <th style="width: 5%">&nbsp;</th>
                        <th style="width: 15%">&nbsp;</th>
                        <th style="width: 5%">&nbsp;</th>
                        <th style="width: 5%">&nbsp;</th>
                        <th style="width: 1%">&nbsp;</th>
                    </tr>
                    <?php foreach ($jobs as $job): ?>
                <tr>
                <td><?=$job->title?></td>
                <td><?=$job->salary?></td>
                <td><?=$job->getCategory()->name?></td>
                <td><a style="float: right" href="jobedit?id=<?=$job->id?>&action=update">Edit</a></td>
                <td><a style="float: right" href="applicants?id=<?=$job->id?>">View applicants (<?=$job->getApplicantCount()?>)</a></td>
                <td><form method="post" action="adminjobs/delete">
				<input type="hidden" name="job[id]" value="<?=$job->id?>" />
				<input type="submit" name="submit" value="Delete" />
				</form>
				<td><form method="post" action="adminjobs/archive">
				<input type="hidden" name="job[id]" value="<?=$job->id?>" />
				<input type="hidden" name="job[title]" value="<?=$job->title?>" />
				<input type="hidden" name="job[salary]" value="<?=$job->salary?>" />
				<input type="hidden" name="job[location]" value="<?=$job->location?>" />
				<input type="hidden" name="job[description]" value="<?=$job->description?>" />
				<input type="hidden" name="job[closingDate]" value="<?=$job->closingDate?>" />
				<input type="hidden" name="job[categoryId]" value="<?=$job->categoryId?>" />
				<input type="hidden" name="job[authorId]" value="<?=$job->authorId?>" />
				<td><input type="submit" name="archive" value="Archive" /></td>
				</form></td>
                </tr>
                    <?php endforeach; ?>
            </thead>
            </table>

        <th style="height:10%">&nbsp;</th>
        <a class ="new"><h2>Archived Jobs</h2></a>

        <table>
            <thead>
            <tr>
                <th>Title</th>
                <th style="width: 10%">Salary</th>
                <th style="width: 5%">Category</th>
                <th style="width: 5%">&nbsp;</th>
                <th style="width: 15%">&nbsp;</th>
                <th style="width: 5%">&nbsp;</th>
                <th style="width: 5%">&nbsp;</th>
            </tr>
            <?php foreach ($archive as $archivejob):?>
            <tr>
                <td><?=$archivejob->title?></td>
                <td><?=$archivejob->salary?></td>
                <td><?=$archivejob->getCategory()->name?></td>
                <td><form method="post" action="adminjobs/repost">
                        <input type="hidden" name="archivejob[id]" value="<?=$archivejob->id;?>" />
                        <input type="submit" name="submit" value="Re-post"/>
                        <input type="hidden" name="archivejob[title]" value="<?=$archivejob->title;?>" />
                        <input type="hidden" name="archivejob[salary]" value="<?=$archivejob->salary;?>" />
                        <input type="hidden" name="archivejob[location]" value="<?=$archivejob->location;?>" />
                        <input type="hidden" name="archivejob[description]" value="<?=$archivejob->description;?>" />
                        <input type="hidden" name="archivejob[closingDate]" value="<?=$archivejob->closingDate;?>" />
                        <input type="hidden" name="archivejob[categoryId]" value="<?=$archivejob->categoryId;?>" />
                        <input type="hidden" name="archivejob[authorId]" value="<?=$archivejob->authorId;?>" />
                </form>
            </tr>
            <?php endforeach; ?>
            </thead>
            </table>
    </section>
</main>