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
$label = 'ALL_STREAM';
$heading = '全部文章';
$desc = '按发布时间解码全部内容。';
if ($category) {
    $base = '/sort/' . (int)$category['id'];
    $label = 'CATEGORY_STREAM';
    $heading = '分类：' . ($category['name'] ?? '分类');
    $desc = trim((string)($category['description'] ?? '')) ?: '当前分类下的文章数据。';
} elseif ($tag) {
    $base = '/tags/' . (int)$tag['id'];
    $label = 'TAG_STREAM';
    $heading = '标签：' . ($tag['name'] ?? '标签');
    $desc = '命中该标签的文章数据。';
} elseif ($keyword !== '') {
    $base = '/search/' . rawurlencode($keyword);
    $label = 'SEARCH_RESULT';
    $heading = '搜索：' . $keyword;
    $desc = '关键词检索结果。';
}
?>
<section class="list-command reveal">
    <p class="terminal-line">query --view <?= h($label) ?> --page <?= (int)$pagination['page'] ?></p>
    <h1><?= h($heading) ?></h1>
    <p><?= h($desc) ?></p>
</section>
<section class="data-stream">
    <?php if (!$listPosts): ?>
        <article class="empty-panel reveal">
            <p class="panel-kicker">NO_DATA</p>
            <h2>没有找到文章</h2>
            <p>可以换一个关键词，或回到首页继续浏览。</p>
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
        <a href="<?= h($first) ?>">FIRST</a>
        <a href="<?= h($prev) ?>">PREV</a>
        <span><?= (int)$pagination['page'] ?> / <?= (int)$pagination['pages'] ?></span>
        <a href="<?= h($next) ?>">NEXT</a>
        <a href="<?= h($last) ?>">LAST</a>
    </nav>
<?php endif; ?>
<?php include theme_file('foot.php'); ?>
