<?php include theme_file('head.php'); ?>
<?php
$commonLinks = normalize_public_links($settings['nav_common_links'] ?? []);
$friendLinks = normalize_public_links($settings['friend_links'] ?? []);
?>
<article class="read-article">
    <header class="article-hero compact">
        <p class="kicker">Links</p>
        <h1>友链导航</h1>
        <p>常用站点与朋友们的链接。</p>
    </header>
    <section class="link-section">
        <h2>常用导航</h2>
        <?php if ($commonLinks): ?>
            <div class="link-grid">
                <?php foreach ($commonLinks as $link): ?>
                    <a href="<?= h($link['url']) ?>" target="_blank" rel="nofollow noopener">
                        <strong><?= h($link['name']) ?></strong>
                        <span><?= h(parse_url($link['url'], PHP_URL_HOST) ?: $link['url']) ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="empty-panel">暂无常用导航。</p>
        <?php endif; ?>
    </section>
    <section class="link-section">
        <h2>友情链接</h2>
        <?php if ($friendLinks): ?>
            <div class="link-grid">
                <?php foreach ($friendLinks as $link): ?>
                    <a href="<?= h($link['url']) ?>" target="_blank" rel="noopener">
                        <strong><?= h($link['name']) ?></strong>
                        <span><?= h(parse_url($link['url'], PHP_URL_HOST) ?: $link['url']) ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="empty-panel">暂无友情链接。</p>
        <?php endif; ?>
    </section>
</article>
<?php include theme_file('foot.php'); ?>
