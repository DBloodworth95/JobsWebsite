<main class="sidebar">

    <section class="left">
        <ul>
            <li><a href="/adminjobs">Jobs</a></li>
            <?php if($authorId->accessLevel == 1 || $authorId->accessLevel == 2):?>
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
            <?php if($authorId->id == $job->authorId || $authorId->accessLevel == 1 || $authorId->accessLevel == 2): ?>
            <h2>Applicants for <?=$job->title;?></h2>

            <table>
            <thead>
            <tr>
                <th style="width: 10%">Name</th>
            <th style="width: 10%">Email</th>
            <th style="width: 65%">Details</th>
            <th style="width: 15%">CV</th>
            </tr>
            <?php
            foreach ($job->getApplicants() as $applicant): ?>
                <tr>
                <td><?php echo $applicant->name; ?></td>
                <td><?php echo $applicant->email; ?></td>
                <td><?php echo $applicant->details; ?></td>
                <td><a href="/cvs/<?=$applicant->cv;?>">Download CV</a></td>
                </tr>
           <?php endforeach; ?>
            </thead>
            </table>
        <?php else:?>
        <p>You do not have permissions to access this page!</p>
        <?php endif; ?>
    </section>
</main>