<?php include theme_file('head.php'); ?>
<?php
$stats = Blog::siteStats();
$categories = Blog::categories();
$tags = Blog::tags();
$latest = array_values(array_filter(array_map(function ($post) {
    return table('posts')->find((int)($post['id'] ?? 0));
}, Blog::latestPosts(12))));
$feature = $latest[0] ?? null;
$picks = array_slice($latest, 1, 3);
$stream = array_slice($latest, 4, 8);
$updatedAt = $stats['latest_updated_at'] ?? ($stats['latest_created_at'] ?? '');
?>
<section class="atlas-hero">
    <?php if ($feature): ?>
        <article class="cover-story">
            <a class="cover-media" href="/read/<?= (int)$feature['id'] ?>.html">
                <img src="<?= h(post_cover_url($feature)) ?>" alt="<?= h($feature['title']) ?>" loading="eager" decoding="async">
            </a>
            <div class="cover-copy">
                <p class="kicker">Cover Story</p>
                <h1><a href="/read/<?= (int)$feature['id'] ?>.html"><?= h($feature['title']) ?></a></h1>
                <p><?= h(($feature['summary'] ?? '') ?: excerpt_text(($feature['markdown'] ?? '') ?: ($feature['html'] ?? ''), 220)) ?></p>
                <div class="post-meta">
                    <a href="/sort/<?= (int)($feature['category_id'] ?? 0) ?>.html"><?= h(Blog::categoryName($feature['category_id'] ?? 0)) ?></a>
                    <span><?= h(display_date($feature['created_at'], 'Y-m-d')) ?></span>
                    <span><?= (int)($feature['views'] ?? 0) ?> 次阅读</span>
                </div>
                <a class="primary-link" href="/read/<?= (int)$feature['id'] ?>.html">阅读专题</a>
            </div>
        </article>
    <?php else: ?>
        <article class="cover-story is-empty">
            <div class="cover-copy">
                <p class="kicker">Atlas Magazine</p>
                <h1><?= h($settings['site_name'] ?? '我的博客') ?></h1>
                <p><?= h(trim((string)($settings['description'] ?? '')) ?: '把值得反复阅读的内容整理成一本文字杂志。') ?></p>
            </div>
        </article>
    <?php endif; ?>
    <aside class="atlas-stats" aria-label="站点概览">
        <p class="kicker">Issue Notes</p>
        <h2><?= h($settings['site_name'] ?? '我的博客') ?></h2>
        <p><?= h(trim((string)($settings['description'] ?? '')) ?: '在技术、经验、灵感和日常之间整理长期内容。') ?></p>
        <div class="stat-grid">
            <span><strong><?= (int)($stats['posts'] ?? 0) ?></strong>文章</span>
            <span><strong><?= count($categories) ?></strong>分类</span>
            <span><strong><?= (int)($stats['views'] ?? 0) ?></strong>访问</span>
            <span><strong><?= h($updatedAt ? display_date($updatedAt, 'm.d') : date('m.d')) ?></strong>更新</span>
        </div>
    </aside>
</section>

<section class="section-block">
    <div class="section-head">
        <p class="kicker">Editorial Picks</p>
        <h2>编辑精选</h2>
    </div>
    <?php if ($picks): ?>
        <div class="pick-grid">
            <?php foreach ($picks as $index => $post): ?>
                <article class="pick-card <?= $index === 0 ? 'is-large' : '' ?>">
                    <a href="/read/<?= (int)$post['id'] ?>.html">
                        <img src="<?= h(post_cover_url($post)) ?>" alt="<?= h($post['title']) ?>" loading="lazy" decoding="async">
                        <span><?= h(Blog::categoryName($post['category_id'] ?? 0)) ?></span>
                        <strong><?= h($post['title']) ?></strong>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-panel">暂无精选文章。</div>
    <?php endif; ?>
</section>

<section class="section-block">
    <div class="section-head">
        <p class="kicker">Departments</p>
        <h2>分类频道</h2>
    </div>
    <div class="channel-grid">
        <?php foreach ($categories as $item): ?>
            <?php
            $categoryIds = Blog::postsByCategory((int)$item['id']);
            $latestPost = $categoryIds ? table('posts')->find((int)$categoryIds[0], 'title') : null;
            ?>
            <a class="channel-card" href="/sort/<?= (int)$item['id'] ?>.html">
                <span><?= (int)($item['count'] ?? count($categoryIds)) ?> 篇</span>
                <strong><?= h($item['name']) ?></strong>
                <em><?= h($latestPost['title'] ?? '等待第一篇内容') ?></em>
            </a>
        <?php endforeach; ?>
        <?php if (!$categories): ?><div class="empty-panel">暂无分类。</div><?php endif; ?>
    </div>
</section>

<section class="section-block">
    <div class="section-head">
        <p class="kicker">Reading Stream</p>
        <h2>继续阅读</h2>
        <a href="/list/1.html">全部文章</a>
    </div>
    <div class="post-stream">
        <?php foreach ($stream as $post): ?>
            <?php include theme_file('post-card.php'); ?>
        <?php endforeach; ?>
        <?php if (!$stream): ?><div class="empty-panel">暂无更多文章。</div><?php endif; ?>
    </div>
</section>

<?php if ($tags): ?>
    <section class="tag-runway" aria-label="标签">
        <?php foreach ($tags as $tagItem): ?>
            <a href="/tags/<?= (int)$tagItem['id'] ?>.html"><?= h($tagItem['name']) ?></a>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
<?php include theme_file('foot.php'); ?>
