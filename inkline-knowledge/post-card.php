<?php
$categoryName = Blog::categoryName($post['category_id']);
$summary = trim((string)($post['summary'] ?: excerpt_text($post['markdown'] ?: $post['html'], 150)));
?>
<article class="note-card">
    <time><?= h(display_date($post['created_at'], 'Y-m-d')) ?></time>
    <div>
        <div class="note-meta">
            <a href="/sort/<?= (int)$post['category_id'] ?>.html"><?= h($categoryName) ?></a>
            <span><?= (int)$post['views'] ?> 次阅读</span>
            <?php if (post_is_protected($post)): ?><span>正文需密码</span><?php endif; ?>
        </div>
        <h2><a href="/read/<?= (int)$post['id'] ?>.html"><?= h($post['title']) ?></a></h2>
        <p><?= h($summary) ?></p>
    </div>
    <a class="read-link" href="/read/<?= (int)$post['id'] ?>.html">阅读</a>
</article>
