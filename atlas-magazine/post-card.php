<?php
$categoryName = Blog::categoryName($post['category_id']);
$summary = trim((string)($post['summary'] ?: excerpt_text($post['markdown'] ?: $post['html'], 140)));
?>
<article class="post-card">
    <a class="post-cover" href="/read/<?= (int)$post['id'] ?>.html" aria-label="<?= h($post['title']) ?>">
        <img src="<?= h(post_cover_url($post)) ?>" alt="<?= h($post['title']) ?>" loading="lazy" decoding="async">
    </a>
    <div class="post-card-main">
        <div class="post-meta">
            <a href="/sort/<?= (int)$post['category_id'] ?>.html"><?= h($categoryName) ?></a>
            <span><?= h(display_date($post['created_at'], 'Y-m-d')) ?></span>
            <?php if (post_is_protected($post)): ?><span>正文需密码</span><?php endif; ?>
        </div>
        <h2><a href="/read/<?= (int)$post['id'] ?>.html"><?= h($post['title']) ?></a></h2>
        <p><?= h($summary) ?></p>
        <div class="post-card-foot">
            <span><?= h($post['author_name'] ?: 'admin') ?></span>
            <span><?= (int)$post['views'] ?> 次阅读</span>
            <a href="/read/<?= (int)$post['id'] ?>.html">继续阅读</a>
        </div>
    </div>
</article>
