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
if ($category) {
    $base = '/sort/' . (int)$category['id'];
} elseif ($tag) {
    $base = '/tags/' . (int)$tag['id'];
} elseif ($keyword !== '') {
    $base = '/search/' . rawurlencode($keyword);
}
?>
<article class="article-list bloglist" id="LAY_bloglist">
    <?php if (!$listPosts): ?>
        <section class="article-item zoomIn article"><h5 class="title">暂无文章</h5><div class="content">这里还没有发布内容。</div></section>
    <?php endif; ?>
    <?php foreach ($listPosts as $post): ?>
        <?php include theme_file('post-card.php'); ?>
    <?php endforeach; ?>
    <section class="article-item zoomIn article">
        <div class="layui-laypage">
            <?php
            $first = $base . ($base === '/list' ? '/1' : '-1') . '.html';
            $prevPage = max(1, $pagination['page'] - 1);
            $nextPage = min($pagination['pages'], $pagination['page'] + 1);
            $prev = $base . ($base === '/list' ? '/' . $prevPage : '-' . $prevPage) . '.html';
            $next = $base . ($base === '/list' ? '/' . $nextPage : '-' . $nextPage) . '.html';
            $last = $base . ($base === '/list' ? '/' . $pagination['pages'] : '-' . $pagination['pages']) . '.html';
            ?>
            <a href="<?= h($first) ?>">首页</a><a href="<?= h($prev) ?>">上一页</a><span><em><?= (int)$pagination['page'] ?>/<?= (int)$pagination['pages'] ?></em></span><a href="<?= h($next) ?>">下一页</a><a href="<?= h($last) ?>">尾页</a>
        </div>
    </section>
</article>
<?php include theme_file('foot.php'); ?>
