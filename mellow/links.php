<?php include theme_file('head.php'); ?>
<?php
$commonLinks = normalize_public_links($settings['nav_common_links'] ?? []);
$friendLinks = normalize_public_links($settings['friend_links'] ?? []);
?>
<article class="read-card">
    <header class="read-head">
        <p class="eyebrow">Links</p>
        <h1>友链导航</h1>
        <p>常用站点与朋友们的链接，像花园里的小路一样放在这里。</p>
    </header>
    <div class="link-section">
        <h2>常用导航</h2>
        <?php if ($commonLinks): ?>
            <div class="link-grid">
                <?php foreach ($commonLinks as $link): ?>
                    <a href="<?= h($link['url']) ?>" target="_blank" rel="nofollow noopener"><strong><?= h($link['name']) ?></strong><span><?= h(parse_url($link['url'], PHP_URL_HOST) ?: $link['url']) ?></span></a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="empty-comment">暂无常用导航。</p>
        <?php endif; ?>
    </div>
    <div class="link-section">
        <h2>友情链接</h2>
        <?php if ($friendLinks): ?>
            <div class="link-grid">
                <?php foreach ($friendLinks as $link): ?>
                    <a href="<?= h($link['url']) ?>" target="_blank" rel="noopener"><strong><?= h($link['name']) ?></strong><span><?= h(parse_url($link['url'], PHP_URL_HOST) ?: $link['url']) ?></span></a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="empty-comment">暂无友情链接。</p>
        <?php endif; ?>
    </div>
</article>
<?php include theme_file('foot.php'); ?>
