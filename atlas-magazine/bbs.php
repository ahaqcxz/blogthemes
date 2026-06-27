<?php include theme_file('head.php'); ?>
<article class="read-article">
    <header class="article-hero compact">
        <p class="kicker">Message Board</p>
        <h1>留言板</h1>
        <p>欢迎留下建议、问题或只是打个招呼。</p>
    </header>
    <div class="read-content">
        <?php $post = ['id' => 0]; include theme_file('comment.php'); ?>
    </div>
</article>
<?php include theme_file('foot.php'); ?>
