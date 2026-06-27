<?php include theme_file('head.php'); ?>
<?php
$stats = Blog::siteStats();
$latest = Blog::latestPosts(9);
$hot = Blog::hotPosts(5);
$categories = Blog::categories();
$tags = Blog::tags();
$feature = $latest[0] ?? null;
$spotlight = array_slice($latest, 1, 4);
$updatedAt = $stats['latest_updated_at'] ?? ($stats['latest_created_at'] ?? '');
?>
<section class="holo-hero enter">
    <div class="hero-copy">
        <p class="eyebrow">HOLOGRAPHIC LIBRARY</p>
        <h1><?= h($settings['site_name'] ?? '我的博客') ?></h1>
        <p><?= h(trim((string)($settings['description'] ?? '')) ?: '把知识、经验和灵感折射成可阅读的信息舱。') ?></p>
        <form class="hero-search" onsubmit="siteSearch('holoHeroKeyword');return false;">
            <label class="sr-only" for="holoHeroKeyword">搜索文章</label>
            <input id="holoHeroKeyword" placeholder="搜索文章、教程或关键词">
            <button type="submit">探索</button>
        </form>
    </div>
    <div class="holo-metrics">
        <span><strong><?= (int)($stats['posts'] ?? 0) ?></strong>文章</span>
        <span><strong><?= (int)($stats['views'] ?? 0) ?></strong>访问</span>
        <span><strong><?= count($categories) ?></strong>分类</span>
        <span><strong><?= h($updatedAt ? display_date($updatedAt, 'm.d') : date('m.d')) ?></strong>更新</span>
    </div>
</section>

<?php if ($feature): ?>
    <article class="focus-card enter">
        <a class="focus-image" href="/read/<?= (int)$feature['id'] ?>.html">
            <img src="<?= h(post_cover_url($feature)) ?>" alt="<?= h($feature['title']) ?>" loading="lazy">
        </a>
        <div class="focus-copy">
            <p class="eyebrow">FOCUS ARTICLE</p>
            <h2><a href="/read/<?= (int)$feature['id'] ?>.html"><?= h($feature['title']) ?></a></h2>
            <p><?= h($feature['summary'] ?: excerpt_text($feature['markdown'] ?: $feature['html'], 190)) ?></p>
            <div class="holo-tags">
                <a href="/sort/<?= (int)$feature['category_id'] ?>.html"><?= h(Blog::categoryName($feature['category_id'])) ?></a>
                <span><?= h(display_date($feature['created_at'], 'Y-m-d')) ?></span>
            </div>
        </div>
    </article>
<?php endif; ?>

<section class="holo-sections">
    <div class="light-panel enter">
        <div class="section-title"><p class="eyebrow">CHANNELS</p><h2>分类光幕</h2></div>
        <div class="category-ribbon">
            <?php foreach ($categories as $item): ?>
                <a href="/sort/<?= (int)$item['id'] ?>.html"><span><?= h($item['name']) ?></span><em><?= (int)($item['count'] ?? 0) ?></em></a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="light-panel enter">
        <div class="section-title"><p class="eyebrow">LATEST</p><h2>最新模块</h2></div>
        <div class="mini-grid">
            <?php foreach ($spotlight as $post): ?>
                <a href="/read/<?= (int)$post['id'] ?>.html">
                    <time><?= h(display_date($post['created_at'], 'm.d')) ?></time>
                    <strong><?= h($post['title']) ?></strong>
                    <span><?= h(Blog::categoryName($post['category_id'])) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="light-panel enter">
        <div class="section-title"><p class="eyebrow">POPULAR</p><h2>高亮阅读</h2></div>
        <div class="rank-list">
            <?php foreach ($hot as $index => $post): ?>
                <a href="/read/<?= (int)$post['id'] ?>.html"><span><?= (int)$index + 1 ?></span><?= h($post['title']) ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="light-panel enter">
        <div class="section-title"><p class="eyebrow">TAGS</p><h2>标签星云</h2></div>
        <div class="tag-cloud">
            <?php foreach (array_slice($tags, 0, 24) as $tagItem): ?>
                <a href="/tags/<?= (int)$tagItem['id'] ?>.html"><?= h($tagItem['name']) ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php include theme_file('foot.php'); ?>
