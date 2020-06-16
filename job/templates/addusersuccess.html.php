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
                <li><a href="enquirymanage">Enquiries</a></li>
            <?php endif; ?>
        </ul>
    </section>
    <section class="right">
        <h2>User Created! <a href="../user/manage">Go Back</a></h2>
    </section>
</main>