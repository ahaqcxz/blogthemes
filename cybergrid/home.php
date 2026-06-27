<?php include theme_file('head.php'); ?>
<?php
$stats = Blog::siteStats();
$latest = array_values(array_filter(array_map(function ($post) {
    return table('posts')->find((int)($post['id'] ?? 0));
}, Blog::latestPosts(8))));
$hot = Blog::hotPosts(6);
$categories = Blog::categories();
$tags = Blog::tags();
$feature = $latest[0] ?? null;
$latestRest = array_slice($latest, 1, 5);
$updatedAt = $stats['latest_updated_at'] ?? ($stats['latest_created_at'] ?? '');
?>
<section class="hud-hero reveal">
    <div class="hero-copy">
        <p class="terminal-line">boot://<?= h($settings['site_name'] ?? '我的博客') ?>/index</p>
        <h1 data-text="<?= h($settings['site_name'] ?? '我的博客') ?>"><?= h($settings['site_name'] ?? '我的博客') ?></h1>
        <p><?= h(trim((string)($settings['description'] ?? '')) ?: '技术笔记、经验记录和灵感缓存正在同步。') ?></p>
        <form class="hero-search" onsubmit="siteSearch('cyberHeroKeyword');return false;">
            <label class="sr-only" for="cyberHeroKeyword">搜索文章</label>
            <input id="cyberHeroKeyword" placeholder="输入关键词后执行搜索">
            <button type="submit">EXECUTE</button>
        </form>
    </div>
    <div class="status-board">
        <span>POSTS <strong><?= (int)($stats['posts'] ?? 0) ?></strong></span>
        <span>VIEWS <strong><?= (int)($stats['views'] ?? 0) ?></strong></span>
        <span>TAGS <strong><?= count($tags) ?></strong></span>
        <span>SYNC <strong><?= h($updatedAt ? display_date($updatedAt, 'm.d') : date('m.d')) ?></strong></span>
    </div>
</section>

<section class="console-grid">
    <?php if ($feature): ?>
        <article class="feature-panel reveal">
            <a class="feature-cover" href="/read/<?= (int)$feature['id'] ?>.html">
                <img src="<?= h(post_cover_url($feature)) ?>" alt="<?= h($feature['title']) ?>" loading="lazy">
            </a>
            <div>
                <p class="panel-kicker">FEATURE_PACKET</p>
                <h2><a href="/read/<?= (int)$feature['id'] ?>.html"><?= h($feature['title']) ?></a></h2>
                <p><?= h(($feature['summary'] ?? '') ?: excerpt_text(($feature['markdown'] ?? '') ?: ($feature['html'] ?? ''), 180)) ?></p>
                <div class="chip-row">
                    <a href="/sort/<?= (int)($feature['category_id'] ?? 0) ?>.html"><?= h(Blog::categoryName($feature['category_id'] ?? 0)) ?></a>
                    <span><?= h(display_date($feature['created_at'], 'Y-m-d')) ?></span>
                    <span><?= (int)($feature['views'] ?? 0) ?> reads</span>
                </div>
            </div>
        </article>
    <?php endif; ?>

    <section class="matrix-panel reveal">
        <div class="section-head">
            <p class="panel-kicker">CATEGORY_MATRIX</p>
            <h2>分类矩阵</h2>
        </div>
        <div class="category-matrix">
            <?php foreach ($categories as $item): ?>
                <a href="/sort/<?= (int)$item['id'] ?>.html">
                    <span><?= h($item['name']) ?></span>
                    <em><?= (int)($item['count'] ?? 0) ?> files</em>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="feed-panel reveal">
        <div class="section-head">
            <p class="panel-kicker">RECENT_STREAM</p>
            <h2>最新数据流</h2>
        </div>
        <div class="terminal-list">
            <?php foreach ($latestRest as $post): ?>
                <a href="/read/<?= (int)$post['id'] ?>.html">
                    <time><?= h(display_date($post['created_at'], 'm-d')) ?></time>
                    <strong><?= h($post['title']) ?></strong>
                    <span><?= h(Blog::categoryName($post['category_id'] ?? 0)) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="hot-panel reveal">
        <div class="section-head">
            <p class="panel-kicker">SCAN_HOT</p>
            <h2>热读扫描</h2>
        </div>
        <div class="scan-list">
            <?php foreach ($hot as $index => $post): ?>
                <a href="/read/<?= (int)$post['id'] ?>.html"><span><?= str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT) ?></span><?= h($post['title']) ?></a>
            <?php endforeach; ?>
        </div>
    </section>
</section>

<section class="tag-console reveal">
    <p class="panel-kicker">TAG_COMMANDS</p>
    <div>
        <?php foreach (array_slice($tags, 0, 28) as $tagItem): ?>
            <a href="/tags/<?= (int)$tagItem['id'] ?>.html">#<?= h($tagItem['name']) ?></a>
        <?php endforeach; ?>
    </div>
</section>
<?php include theme_file('foot.php'); ?>
