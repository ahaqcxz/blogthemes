<?php include theme_file('head.php'); ?>
<?php
$commonLinks = normalize_public_links($settings['nav_common_links'] ?? []);
$friendLinks = normalize_public_links($settings['friend_links'] ?? []);
?>
<article class="article-shell enter">
    <header class="article-head">
        <p class="eyebrow">LINKS</p>
        <h1>友链导航</h1>
        <p>常用站点与朋友链接。</p>
    </header>
    <section class="link-section">
        <div class="section-title"><p class="eyebrow">NAVIGATION</p><h2>常用导航</h2></div>
        <div class="link-grid">
            <?php foreach ($commonLinks as $link): ?>
                <a href="<?= h($link['url']) ?>" target="_blank" rel="nofollow noopener"><strong><?= h($link['name']) ?></strong><span><?= h(parse_url($link['url'], PHP_URL_HOST) ?: $link['url']) ?></span></a>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="link-section">
        <div class="section-title"><p class="eyebrow">FRIENDS</p><h2>友情链接</h2></div>
        <div class="link-grid">
            <?php foreach ($friendLinks as $link): ?>
                <a href="<?= h($link['url']) ?>" target="_blank" rel="noopener"><strong><?= h($link['name']) ?></strong><span><?= h(parse_url($link['url'], PHP_URL_HOST) ?: $link['url']) ?></span></a>
            <?php endforeach; ?>
        </div>
    </section>
</article>
<?php include theme_file('foot.php'); ?>
