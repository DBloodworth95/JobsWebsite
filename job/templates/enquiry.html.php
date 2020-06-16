<main class="sidebar">

    <section class="left">
        <ul>
            <?php foreach($categories as $category): ?>
                <blockquote>
                    <li><a href="/jobs/?id=<?=$category->id?>"><?=$category->name?></a></li>
                </blockquote>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="right">
            <h1>Ask a question</h1>
        <?php if(count($errors) > 0): ?>
        <?php foreach ($errors as $error): ?>
        <p><?=$error?></p>
        <?php endforeach; ?>
        <?php endif; ?>
        <form action="" method="POST">
            <label>Name</label>
            <input type="text" name="enquiry[name]" value="" />
            <label>Email</label>
            <input type="text" name="enquiry[email]" value="" />
            <label>Telephone</label>
            <input type="text" name="enquiry[telephone]" value="" />
            <label>Enquiry</label>
            <input type="text" name="enquiry[enquiry]" value="" />
            <input type="submit" name="submit" value="Submit Question" />
    </section>