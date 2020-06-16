<main class="home">
    <section class="right">

            <h1>Jobs ending soon</h1>

        <ul class="listing">
            <?php foreach($jobs as $job) { ?>
                <blockquote>
                    <li>
                        <div class="details">
                            <h2><?=$job->title?></h2>
                            <h3><?=$job->salary?></h3>
                            <p><?=nl2br($job->description)?></p>
                            <a class="more" href="jobs/apply?id=<?=$job->id?>">Apply for this job</a>
                        </div>
                    </li>
                </blockquote>
            <?php } ?>
        </ul>
    </section>

</main>

