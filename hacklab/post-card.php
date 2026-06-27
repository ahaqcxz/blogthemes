<?php
$categoryName = Blog::categoryName($post['category_id']);
$cover = post_cover_url($post);
$summary = trim((string)($post['summary'] ?: excerpt_text($post['markdown'] ?: $post['html'], 150)));
?>
<article class="post-card">
    <a class="post-cover" href="/read/<?= (int)$post['id'] ?>.html" aria-label="<?= h($post['title']) ?>"><img src="<?= h($cover) ?>" alt="<?= h($post['title']) ?>" loading="lazy" decoding="async"></a>
    <div class="post-card-main">
        <div class="post-meta">
            <a href="/sort/<?= (int)$post['category_id'] ?>.html"><?= h($categoryName) ?></a>
            <span><?= h(display_date($post['created_at'], 'Y-m-d')) ?></span>
            <span><?= (int)$post['views'] ?> reads</span>
            <?php if (post_is_protected($post)): ?><span>locked</span><?php endif; ?>
        </div>
        <h2><a href="/read/<?= (int)$post['id'] ?>.html"><span>$ open</span> <?= h($post['title']) ?></a></h2>
        <p><?= h($summary) ?></p>
        <div class="post-card-foot">
            <span>author: <?= h($post['author_name'] ?: 'admin') ?></span>
            <a href="/read/<?= (int)$post['id'] ?>.html">read --full</a>
        </div>
    </div>
</article>
