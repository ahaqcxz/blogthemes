<?php include theme_file('head.php'); ?>
<article class="article-shell enter">
    <header class="article-head">
        <p class="eyebrow">MESSAGE BOARD</p>
        <h1>留言板</h1>
        <p>欢迎留下建议、问题或只是打个招呼。</p>
    </header>
    <div class="article-content">
        <?php $post = ['id' => 0]; include theme_file('comment.php'); ?>
    </div>
</article>
<?php include theme_file('foot.php'); ?>
