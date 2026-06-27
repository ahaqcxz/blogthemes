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
$label = 'ARTICLE INDEX';
$heading = '全部文章';
$desc = '用更清晰的信息层级浏览所有内容。';
if ($category) {
    $base = '/sort/' . (int)$category['id'];
    $label = 'CATEGORY';
    $heading = '分类：' . ($category['name'] ?? '分类');
    $desc = trim((string)($category['description'] ?? '')) ?: '这个分类下的文章索引。';
} elseif ($tag) {
    $base = '/tags/' . (int)$tag['id'];
    $label = 'TAG';
    $heading = '标签：' . ($tag['name'] ?? '标签');
    $desc = '与该标签相关的内容集合。';
} elseif ($keyword !== '') {
    $base = '/search/' . rawurlencode($keyword);
    $label = 'SEARCH';
    $heading = '搜索：' . $keyword;
    $desc = '站内关键词搜索结果。';
}
?>
<section class="archive-head enter">
    <p class="eyebrow"><?= h($label) ?></p>
    <h1><?= h($heading) ?></h1>
    <p><?= h($desc) ?></p>
</section>
<section class="holo-list">
    <?php if (!$listPosts): ?>
        <article class="empty-state enter">
            <h2>暂无内容</h2>
            <p>可以换一个关键词，或返回首页查看最新文章。</p>
        </article>
    <?php endif; ?>
    <?php foreach ($listPosts as $index => $post): ?>
        <?php include theme_file('post-card.php'); ?>
    <?php endforeach; ?>
</section>
<?php if ($pagination['pages'] > 1): ?>
    <nav class="pagination" aria-label="分页">
        <?php
        $prevPage = max(1, $pagination['page'] - 1);
        $nextPage = min($pagination['pages'], $pagination['page'] + 1);
        $first = $base . ($base === '/list' ? '/1' : '-1') . '.html';
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
