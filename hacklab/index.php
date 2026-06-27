<?php include theme_file('head.php'); ?>
<?php
$perPage = (int)($settings['per_page'] ?? 10);
$pagination = table('posts')->page($ids, $page, $perPage);
$listPosts = [];
foreach ($pagination['ids'] as $id) {
    $row = table('posts')->find($id);
    if ($row) $listPosts[] = $row;
}
$base = '/list';
$listTitle = 'ls ./posts';
$listDesc = '读取最新技术笔记、调试记录和极客观察。';
if ($category) {
    $base = '/sort/' . (int)$category['id'];
    $listTitle = 'cd /category/' . ($category['name'] ?? '分类');
    $listDesc = trim((string)($category['description'] ?? '')) ?: '当前分类下的全部文章。';
} elseif ($tag) {
    $base = '/tags/' . (int)$tag['id'];
    $listTitle = 'filter --tag=' . ($tag['name'] ?? '标签');
    $listDesc = '输出匹配该标签的文章。';
} elseif ($keyword !== '') {
    $base = '/search/' . rawurlencode($keyword);
    $listTitle = 'grep "' . $keyword . '" ./posts';
    $listDesc = '站内搜索结果。';
}
$siteStats = Blog::siteStats();
?>
<header class="hero-console">
    <div class="console-title">
        <span class="dot red"></span><span class="dot yellow"></span><span class="dot green"></span>
        <strong>hacklab.session</strong>
    </div>
    <div class="console-body">
        <p class="command">$ <?= h($listTitle) ?></p>
        <h1><?= h($listDesc) ?></h1>
        <div class="metrics-grid">
            <span><b><?= (int)$siteStats['article_count'] ?></b> posts</span>
            <span><b><?= (int)$siteStats['total_views'] ?></b> views</span>
            <span><b><?= (int)$siteStats['running_days'] ?></b> days</span>
            <span><b><?= h($siteStats['last_updated_display']) ?></b> update</span>
        </div>
    </div>
</header>
<div class="post-list">
    <?php if (!$listPosts): ?>
        <article class="empty-card"><p class="command">$ cat result.log</p><h2>没有匹配内容</h2><p>当前查询没有返回文章。</p></article>
    <?php endif; ?>
    <?php foreach ($listPosts as $post): ?>
        <?php include theme_file('post-card.php'); ?>
    <?php endforeach; ?>
</div>
<?php if ($pagination['pages'] > 1): ?>
    <nav class="pagination" aria-label="分页">
        <?php
        $first = $base . ($base === '/list' ? '/1' : '-1') . '.html';
        $prevPage = max(1, $pagination['page'] - 1);
        $nextPage = min($pagination['pages'], $pagination['page'] + 1);
        $prev = $base . ($base === '/list' ? '/' . $prevPage : '-' . $prevPage) . '.html';
        $next = $base . ($base === '/list' ? '/' . $nextPage : '-' . $nextPage) . '.html';
        $last = $base . ($base === '/list' ? '/' . $pagination['pages'] : '-' . $pagination['pages']) . '.html';
        ?>
        <a href="<?= h($first) ?>">--first</a><a href="<?= h($prev) ?>">--prev</a><span><?= (int)$pagination['page'] ?>/<?= (int)$pagination['pages'] ?></span><a href="<?= h($next) ?>">--next</a><a href="<?= h($last) ?>">--last</a>
    </nav>
<?php endif; ?>
<?php include theme_file('foot.php'); ?>
