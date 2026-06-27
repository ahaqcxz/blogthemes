<?php include theme_file('head.php'); ?>
<article class="read-panel reveal">
    <header class="read-head">
        <p class="terminal-line">open --channel message-board</p>
        <h1>留言板</h1>
        <p>留下建议、问题或一条新的通信记录。</p>
    </header>
    <div class="read-content">
        <?php $post = ['id' => 0]; include theme_file('comment.php'); ?>
    </div>
</article>
<?php include theme_file('foot.php'); ?>
