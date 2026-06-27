<?php include theme_file('head.php'); ?>
<?php
$stats = Blog::siteStats();
$categories = Blog::categories();
$tags = Blog::tags();
$latest = array_values(array_filter(array_map(function ($post) {
    return table('posts')->find((int)($post['id'] ?? 0));
}, Blog::latestPosts(12))));
$hot = Blog::hotPosts(6);
$updatedAt = $stats['latest_updated_at'] ?? ($stats['latest_created_at'] ?? '');
?>
<section class="knowledge-dashboard">
    <div class="dashboard-copy">
        <p class="eyebrow">Knowledge Index</p>
        <h1><?= h($settings['site_name'] ?? '我的博客') ?></h1>
        <p><?= h(trim((string)($settings['description'] ?? '')) ?: '把技术笔记、经验教程和长期资料整理成可检索的个人知识库。') ?></p>
        <form class="hero-search" onsubmit="siteSearch('inkHeroKeyword');return false;">
            <label class="sr-only" for="inkHeroKeyword">搜索知识库</label>
            <input id="inkHeroKeyword" placeholder="输入关键词搜索文章">
            <button type="submit">开始检索</button>
        </form>
    </div>
    <div class="dashboard-metrics" aria-label="站点统计">
        <span><strong><?= (int)($stats['posts'] ?? 0) ?></strong>文章</span>
        <span><strong><?= count($categories) ?></strong>分类</span>
        <span><strong><?= (int)($stats['views'] ?? 0) ?></strong>访问</span>
        <span><strong><?= h($updatedAt ? display_date($updatedAt, 'Y-m-d') : date('Y-m-d')) ?></strong>最近更新</span>
    </div>
</section>

<section class="layout-grid">
    <div class="main-column">
        <section class="panel">
            <div class="panel-head">
                <p class="eyebrow">Knowledge Map</p>
                <h2>知识地图</h2>
            </div>
            <div class="map-list">
                <?php foreach ($categories as $item): ?>
                    <?php
                    $categoryIds = Blog::postsByCategory((int)$item['id']);
                    $latestPost = $categoryIds ? table('posts')->find((int)$categoryIds[0], 'title|created_at') : null;
                    ?>
                    <a class="map-item" href="/sort/<?= (int)$item['id'] ?>.html">
                        <span><?= (int)($item['count'] ?? count($categoryIds)) ?> 篇</span>
                        <strong><?= h($item['name']) ?></strong>
                        <em><?= h($latestPost['title'] ?? '等待第一篇内容') ?></em>
                    </a>
                <?php endforeach; ?>
                <?php if (!$categories): ?><div class="empty-panel">暂无分类。</div><?php endif; ?>
            </div>
        </section>

        <section class="panel">
            <div class="panel-head">
                <p class="eyebrow">Latest Notes</p>
                <h2>最新笔记</h2>
            </div>
            <div class="note-list">
                <?php foreach ($latest as $post): ?>
                    <?php include theme_file('post-card.php'); ?>
                <?php endforeach; ?>
                <?php if (!$latest): ?><div class="empty-panel">暂无文章。</div><?php endif; ?>
            </div>
        </section>
    </div>

    <aside class="side-column">
        <section class="panel">
            <div class="panel-head">
                <p class="eyebrow">Popular</p>
                <h2>热门参考</h2>
            </div>
            <div class="rank-list">
                <?php foreach ($hot as $index => $post): ?>
                    <a href="/read/<?= (int)$post['id'] ?>.html"><span><?= (int)$index + 1 ?></span><?= h($post['title']) ?></a>
                <?php endforeach; ?>
                <?php if (!$hot): ?><div class="empty-panel">暂无热门文章。</div><?php endif; ?>
            </div>
        </section>

        <section class="panel">
            <div class="panel-head">
                <p class="eyebrow">Tag Index</p>
                <h2>标签索引</h2>
            </div>
            <div class="tag-index">
                <?php foreach ($tags as $tagItem): ?>
                    <a href="/tags/<?= (int)$tagItem['id'] ?>.html"><?= h($tagItem['name']) ?></a>
                <?php endforeach; ?>
                <?php if (!$tags): ?><div class="empty-panel">暂无标签。</div><?php endif; ?>
            </div>
        </section>
    </aside>
</section>
<?php include theme_file('foot.php'); ?>
