<?php include theme_file('head.php'); ?>
<?php
$perPage = (int)($settings['per_page'] ?? 10);
$pagination = table('posts')->page($ids, $page, $perPage);
$listPosts = [];
foreach ($pagination['ids'] as $id) {
    $row = table('posts')->find($id);
    if ($row) {
        $listPosts[] = $row;
    }
}
$base = '/list';
$listTitle = '文章索引';
$listDesc = trim((string)($settings['description'] ?? '')) ?: '按时间整理的知识条目，适合快速检索和持续阅读。';
$listLabel = 'Index';
if ($category) {
    $base = '/sort/' . (int)$category['id'];
    $listTitle = '分类：' . ($category['name'] ?? '分类');
    $listDesc = trim((string)($category['description'] ?? '')) ?: '浏览这个分类下的文章。';
    $listLabel = 'Category';
} elseif ($tag) {
    $base = '/tags/' . (int)$tag['id'];
    $listTitle = '标签：' . ($tag['name'] ?? '标签');
    $listDesc = '围绕这个标签整理的相关文章。';
    $listLabel = 'Tag';
} elseif ($keyword !== '') {
    $base = '/search/' . rawurlencode($keyword);
    $listTitle = '搜索：' . $keyword;
    $listDesc = '站内搜索结果，按发布时间排序。';
    $listLabel = 'Search';
}
?>
<header class="index-intro">
    <div>
        <p class="eyebrow"><?= h($listLabel) ?></p>
        <h1><?= h($listTitle) ?></h1>
        <p><?= h($listDesc) ?></p>
    </div>
    <form class="intro-search" onsubmit="siteSearch('inkIntroKeyword');return false;">
        <label class="sr-only" for="inkIntroKeyword">搜索文章</label>
        <input id="inkIntroKeyword" placeholder="在当前知识库搜索">
        <button type="submit">搜索</button>
    </form>
</header>
<section class="panel">
    <div class="note-list">
        <?php if (!$listPosts): ?>
            <article class="empty-panel">
                <p class="eyebrow">Empty</p>
                <h2>暂无文章</h2>
                <p>这里还没有发布内容，可以换个关键词或返回首页浏览。</p>
            </article>
        <?php endif; ?>
        <?php foreach ($listPosts as $post): ?>
            <?php include theme_file('post-card.php'); ?>
        <?php endforeach; ?>
    </div>
</section>
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
        <a href="<?= h($first) ?>">首页</a>
        <a href="<?= h($prev) ?>">上一页</a>
        <span><?= (int)$pagination['page'] ?> / <?= (int)$pagination['pages'] ?></span>
        <a href="<?= h($next) ?>">下一页</a>
        <a href="<?= h($last) ?>">尾页</a>
    </nav>
<?php endif; ?>
<?php include theme_file('foot.php'); ?>
