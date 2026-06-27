<?php include theme_file('head.php'); ?>
<article class="read-card">
    <header class="read-head">
        <p class="command">$ open bbs.channel</p>
        <h1>留言板</h1>
        <p>留下建议、问题，或者一条来自终端另一端的问候。</p>
    </header>
    <div class="read-content">
        <?php $post = ['id' => 0]; include theme_file('comment.php'); ?>
    </div>
</article>
<?php include theme_file('foot.php'); ?>
