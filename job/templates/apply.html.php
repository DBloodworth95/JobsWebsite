<main class="sidebar">

    <section class="left">
        <ul>
            <li><a href="jobs.php">Jobs</a></li>
            <li><a href="categories.php">Categories</a></li>
        </ul>
    </section>

    <section class="right">

            <h2>Apply for <?=$job->title?></h2>
        <?php if(count($errors) > 0): ?>
            <?php foreach ($errors as $error): ?>
                <p><?=$error?></p>
            <?php endforeach; ?>
        <?php endif; ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <label>Your name</label>
                <input type="text" name="name" />

                <label>E-mail address</label>
                <input type="text" name="email" />

                <label>Cover letter</label>
                <textarea name="details"></textarea>

                <label>CV</label>
                <input type="file" name="cv" />

                <input type="hidden" name="jobId" value="<?=$job->id?>" />

                <input type="submit" name="submit" value="Apply" />

            </form>
    </section>
</main>