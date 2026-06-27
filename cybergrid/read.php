<?php include theme_file('head.php'); ?>
<?php
$post = $singlePost;
$postUrl = site_absolute_url('/read/' . (int)$post['id'] . '.html');
$categoryName = Blog::categoryName($post['category_id']);
$all = Blog::publishedPostIds();
$idx = array_search($post['id'], $all, true);
$prevPost = $idx !== false && isset($all[$idx + 1]) ? table('posts')->find($all[$idx + 1], 'title') : null;
$nextPost = $idx !== false && isset($all[$idx - 1]) ? table('posts')->find($all[$idx - 1], 'title') : null;
$locked = post_is_protected($post) && !post_access_granted($post);
$summary = trim((string)($post['summary'] ?: excerpt_text($post['markdown'] ?: $post['html'], 220)));
?>
<article class="read-panel reveal">
    <header class="read-head">
        <p class="terminal-line">open --post <?= (int)$post['id'] ?> --mode read</p>
        <h1><?= h($post['title']) ?></h1>
        <div class="chip-row">
            <a href="/sort/<?= (int)$post['category_id'] ?>.html"><?= h($categoryName) ?></a>
            <span><?= h(display_date($post['created_at'], 'Y-m-d')) ?></span>
            <span><?= (int)$post['views'] ?> reads</span>
            <span><?= h($post['author_name'] ?: 'admin') ?></span>
        </div>
    </header>
    <div class="read-content">
        <?php if ($locked): ?>
            <?php if ($msg = flash()): ?><div class="notice"><?= h($msg) ?></div><?php endif; ?>
            <p><?= h($summary ?: '这篇文章需要输入访问密码后才能阅读全文。') ?></p>
            <form method="post" class="post-password-form">
                <input type="hidden" name="_csrf" value="<?= h(csrf_token()) ?>">
                <input type="hidden" name="form" value="post_password">
                <input type="hidden" name="post_id" value="<?= (int)$post['id'] ?>">
                <input type="password" name="post_password" placeholder="access token" required>
                <button type="submit">UNLOCK</button>
            </form>
        <?php else: ?>
            <?php if ($msg = flash()): ?><div class="notice"><?= h($msg) ?></div><?php endif; ?>
            <?= optimize_content_images(ensure_image_alt($post['html'] ?: Markdown::render($post['markdown']), $post['title'])) ?>
            <div class="copyright-box">
                <p>license: 非特殊说明，本文版权归 <?= h($post['author_name'] ?: 'admin') ?> 所有，转载请注明出处。</p>
                <p>url: <a href="<?= h($postUrl) ?>"><?= h($postUrl) ?></a></p>
            </div>
            <nav class="post-neighbor">
                <div>PREV <?= $prevPost ? '<a href="/read/' . (int)$prevPost['id'] . '.html">' . h($prevPost['title']) . '</a>' : '<span>NULL</span>' ?></div>
                <div>NEXT <?= $nextPost ? '<a href="/read/' . (int)$nextPost['id'] . '.html">' . h($nextPost['title']) . '</a>' : '<span>NULL</span>' ?></div>
            </nav>
        <?php endif; ?>
    </div>
    <?php if (!$locked): ?>
        <?php include theme_file('comment.php'); ?>
    <?php endif; ?>
</article>
<?php include theme_file('foot.php'); ?>
