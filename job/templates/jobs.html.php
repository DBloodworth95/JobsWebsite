<main class="sidebar">

    <section class="left">
        <ul>
            <?php foreach($categories as $category): ?>
                <blockquote>
                    <li><a href="/jobs/?id=<?=$category->id?>"><?=$category->name?></a></li>
                </blockquote>
            <?php endforeach; ?>
            <li><h2>Filter by Location</h2></li>
            <li><form method="post" action=""></li>
            <select name="locationType">
                <?php foreach ($chosenCategory->getLocations() as $location): ?>
                    <option value="<?=$location->location?>"><?=$location->location?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" name="sortLocation" value="Show"/>
            </form>
        </ul>
    </section>

    <section class="right">

        <h1><?=$chosenCategory->name?></a> Jobs</h1>
    <ul class="listing">
        <?php if (!isset($_POST['sortLocation'])) { ?>
            <?php foreach($chosenCategory->getJobs() as $job) { ?>
            <blockquote>
            <li>
                <div class="details">
                    <h2><?=$job->title?></h2>
                    <h3><?=$job->salary?></h3>
                    <p><?=nl2br($job->description)?></p>
                <a class="more" href="apply?id=<?=$job->id?>">Apply for this job</a>
                </div>
            </li>
            </blockquote>
            <?php } } else {?>
                    <?php foreach($chosenCategory->sortLocation() as $job) { ?>
                    <blockquote>
                        <li>
                            <div class="details">
                                <h2><?=$job->title?></h2>
                                <h3><?=$job->salary?></h3>
                                <p><?=($job->description)?></p>
                                <a class="more" href="apply?id=<?=$job->id?>">Apply for this job</a>
                            </div>
                        </li>
                    </blockquote>
        <?php } } ?>
    </ul>
</section>