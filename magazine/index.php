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
$listTitle = '最新刊文';
$listDesc = '把技术、经验、收藏与日常，整理成一份可翻阅的站点刊物。';
if ($category) {
    $base = '/sort/' . (int)$category['id'];
    $listTitle = '栏目：' . ($category['name'] ?? '分类');
    $listDesc = trim((string)($category['description'] ?? '')) ?: '浏览这个栏目下的文章。';
} elseif ($tag) {
    $base = '/tags/' . (int)$tag['id'];
    $listTitle = '专题：' . ($tag['name'] ?? '标签');
    $listDesc = '这个专题关联的文章。';
} elseif ($keyword !== '') {
    $base = '/search/' . rawurlencode($keyword);
    $listTitle = '检索：' . $keyword;
    $listDesc = '站内搜索结果。';
}
$siteStats = Blog::siteStats();
?>
<header class="list-head">
    <div>
        <p class="eyebrow">Journal</p>
        <h1><?= h($listTitle) ?></h1>
        <p><?= h($listDesc) ?></p>
    </div>
    <div class="list-metrics">
        <span><strong><?= (int)$siteStats['article_count'] ?></strong> 篇</span>
        <span><strong><?= (int)$siteStats['total_views'] ?></strong> 访</span>
        <span>更新 <?= h($siteStats['last_updated_display']) ?></span>
    </div>
</header>
<div class="post-list">
    <?php if (!$listPosts): ?>
        <article class="empty-card"><h2>暂无文章</h2><p>这里还没有发布内容。</p></article>
    <?php endif; ?>
    <?php foreach ($listPosts as $postIndex => $post): ?>
        <?php $isFeaturePost = ($page === 1 && $postIndex === 0 && !$category && !$tag && $keyword === ''); include theme_file('post-card.php'); unset($isFeaturePost); ?>
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
        <a href="<?= h($first) ?>">首页</a><a href="<?= h($prev) ?>">上一页</a><span><?= (int)$pagination['page'] ?> / <?= (int)$pagination['pages'] ?></span><a href="<?= h($next) ?>">下一页</a><a href="<?= h($last) ?>">尾页</a>
    </nav>
<?php endif; ?>
<?php include theme_file('foot.php'); ?>
