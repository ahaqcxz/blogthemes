<?php include theme_file('head.php'); ?>
<?php
$commonLinks = normalize_public_links($settings['nav_common_links'] ?? []);
$friendLinks = normalize_public_links($settings['friend_links'] ?? []);
?>
<section class="article-item zoomIn article link-page">
    <h5 class="title">友链导航</h5>
    <div class="content">
        <div class="link-section">
            <h4>常用导航</h4>
            <?php if ($commonLinks): ?>
                <div class="link-grid">
                    <?php foreach ($commonLinks as $link): ?>
                        <a href="<?= h($link['url']) ?>" target="_blank" rel="nofollow noopener">
                            <span><?= h($link['name']) ?></span>
                            <small><?= h(parse_url($link['url'], PHP_URL_HOST) ?: $link['url']) ?></small>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="empty-comment">暂无常用导航。</p>
            <?php endif; ?>
        </div>
        <div class="link-section">
            <h4>友情链接</h4>
            <?php if ($friendLinks): ?>
                <div class="link-grid friend-link-grid">
                    <?php foreach ($friendLinks as $link): ?>
                        <a href="<?= h($link['url']) ?>" target="_blank" rel="noopener">
                            <span><?= h($link['name']) ?></span>
                            <small><?= h(parse_url($link['url'], PHP_URL_HOST) ?: $link['url']) ?></small>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="empty-comment">暂无友情链接。</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php include theme_file('foot.php'); ?>
