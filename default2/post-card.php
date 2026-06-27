<?php
$categoryName = Blog::categoryName($post['category_id']);
$cover = post_cover_url($post);
$date = display_date($post['created_at'], 'Y-m-d');
$parts = $date ? explode('-', $date) : ['----', '--', '--'];
?>
<section class="article-item zoomIn article">
    <div class="fc-flag"><?= h($categoryName) ?></div>
    <h5 class="title">
        <span class="fc-blue">【<?= h($post['source_type'] ?: '原创') ?>】</span>
        <a href="/read/<?= (int)$post['id'] ?>.html" target="_blank"><?= h($post['title']) ?></a>
    </h5>
    <div class="time">
        <span class="day"><?= h($parts[2]) ?></span>
        <span class="month"><?= h($parts[1]) ?><small>月</small></span>
        <span class="year"><?= h($parts[0]) ?></span>
    </div>
    <div class="content">
        <a href="/read/<?= (int)$post['id'] ?>.html" class="cover img-light" target="_blank"><img src="<?= h($cover) ?>" alt="<?= h($post['title']) ?>" loading="lazy" decoding="async"></a>
        <div class="summary-text"><?= h($post['summary'] ?: excerpt_text($post['markdown'])) ?></div>
    </div>
    <div class="read-more"><a href="/read/<?= (int)$post['id'] ?>.html" class="fc-black">继续阅读</a></div>
    <aside class="footer">
        <div class="tags"><span>🏷</span>
            <?php if (post_is_protected($post)): ?><span class="tag protected-tag">正文需密码</span><?php endif; ?>
            <?php foreach (Blog::tagRowsFromKeys($post['tag_keys']) as $tagRow): ?>
                <a class="tag" href="/tags/<?= (int)$tagRow['id'] ?>.html"><?= h($tagRow['name']) ?></a>
            <?php endforeach; ?>
        </div>
        <div class="meta"><span>👤 <?= h($post['author_name'] ?: 'admin') ?></span><span>👁 <?= (int)$post['views'] ?></span></div>
    </aside>
</section>
