<?php include theme_file('head.php'); ?>
<article class="read-card">
    <header class="read-head">
        <p class="eyebrow">Guestbook</p>
        <h1>留言板</h1>
        <p>欢迎留下建议、问题，或者只是轻轻打个招呼。</p>
    </header>
    <div class="read-content">
        <?php $post = ['id' => 0]; include theme_file('comment.php'); ?>
    </div>
</article>
<?php include theme_file('foot.php'); ?>
