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
$listTitle = 'latest.posts';
$listDesc = '技术笔记、调试记录和经验片段。';
if ($category) {
    $base = '/sort/' . (int)$category['id'];
    $listTitle = 'category/' . ($category['name'] ?? '分类');
    $listDesc = trim((string)($category['description'] ?? '')) ?: '这个分类下的全部文章。';
} elseif ($tag) {
    $base = '/tags/' . (int)$tag['id'];
    $listTitle = 'tag/' . ($tag['name'] ?? '标签');
    $listDesc = '与这个标签相关的文章。';
} elseif ($keyword !== '') {
    $base = '/search/' . rawurlencode($keyword);
    $listTitle = 'grep "' . $keyword . '"';
    $listDesc = '站内搜索结果。';
}
$siteStats = Blog::siteStats();
?>
<header class="list-head">
    <p class="eyebrow">~/blog</p>
    <h1><?= h($listTitle) ?></h1>
    <p><?= h($listDesc) ?></p>
    <div class="list-metrics">
        <span>posts <?= (int)$siteStats['article_count'] ?></span>
        <span>views <?= (int)$siteStats['total_views'] ?></span>
        <span>updated <?= h($siteStats['last_updated_display']) ?></span>
    </div>
</header>
<div class="post-list">
    <?php if (!$listPosts): ?>
        <article class="empty-card"><h2>no posts</h2><p>这里还没有发布内容。</p></article>
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
        <a href="<?= h($first) ?>">first</a><a href="<?= h($prev) ?>">prev</a><span><?= (int)$pagination['page'] ?> / <?= (int)$pagination['pages'] ?></span><a href="<?= h($next) ?>">next</a><a href="<?= h($last) ?>">last</a>
    </nav>
<?php endif; ?>
<?php include theme_file('foot.php'); ?>
