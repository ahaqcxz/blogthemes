<?php include theme_file('head.php'); ?>
<?php
$post = $singlePost;
$postUrl = site_absolute_url('/read/' . (int)$post['id'] . '.html');
$categoryName = Blog::categoryName($post['category_id']);
$date = display_date($post['created_at'], 'Y-m-d');
$parts = $date ? explode('-', $date) : ['----', '--', '--'];
$all = Blog::publishedPostIds();
$idx = array_search($post['id'], $all, true);
$prevPost = $idx !== false && isset($all[$idx + 1]) ? table('posts')->find($all[$idx + 1], 'title') : null;
$nextPost = $idx !== false && isset($all[$idx - 1]) ? table('posts')->find($all[$idx - 1], 'title') : null;
$locked = post_is_protected($post) && !post_access_granted($post);
$summary = trim((string)($post['summary'] ?: excerpt_text($post['markdown'] ?: $post['html'], 220)));
?>
<article class="article-list">
    <section class="article-item">
        <aside class="title article-title">
            <h4><?= h($post['title']) ?></h4>
            <p>
                <small>作者：<?= h($post['author_name'] ?: 'admin') ?></small>
                <small>围观群众：<i><?= (int)$post['views'] ?></i></small>
                <small>更新于 <?= h(display_date($post['updated_at'])) ?></small>
                <small>分类：<a href="/sort/<?= (int)$post['category_id'] ?>.html"><?= h($categoryName) ?></a></small>
            </p>
        </aside>
        <div class="time mt10">
            <span class="day"><?= h($parts[2]) ?></span>
            <span class="month"><?= h($parts[1]) ?><small>月</small></span>
            <span class="year"><?= h($parts[0]) ?></span>
        </div>
        <div class="content artiledetail">
            <?php if ($locked): ?>
                <?php if ($msg = flash()): ?><div class="notice"><?= h($msg) ?></div><?php endif; ?>
                <div class="protected-summary">
                    <p><?= h($summary ?: '这篇文章需要输入访问密码后才能阅读全文。') ?></p>
                </div>
                <form method="post" class="post-password-form">
                    <input type="hidden" name="_csrf" value="<?= h(csrf_token()) ?>">
                    <input type="hidden" name="form" value="post_password">
                    <input type="hidden" name="post_id" value="<?= (int)$post['id'] ?>">
                    <input type="password" name="post_password" placeholder="请输入文章访问密码" required>
                    <button type="submit">阅读全文</button>
                </form>
            <?php else: ?>
                <?php if ($msg = flash()): ?><div class="notice"><?= h($msg) ?></div><?php endif; ?>
                <?= optimize_content_images(ensure_image_alt($post['html'] ?: Markdown::render($post['markdown']), $post['title'])) ?>
                <div class="copyright-box">
                    <p>非特殊说明，本文版权归 <?= h($post['author_name'] ?: 'admin') ?> 所有，转载请注明出处.</p>
                    <p>本文标题：<a href="#"><?= h($post['title']) ?></a></p>
                    <p>本文网址：<a href="<?= h($postUrl) ?>"><?= h($postUrl) ?></a></p>
                </div>
                <ol class="b-relation">
                    <li>上一篇：<?= $prevPost ? '<a href="/read/' . (int)$prevPost['id'] . '.html">' . h($prevPost['title']) . '</a>' : '<a href="#">没有了</a>' ?></li>
                    <li>下一篇：<?= $nextPost ? '<a href="/read/' . (int)$nextPost['id'] . '.html">' . h($nextPost['title']) . '</a>' : '<a href="#">没有了</a>' ?></li>
                </ol>
            <?php endif; ?>
        </div>
        <?php if (!$locked): ?>
            <?php include theme_file('comment.php'); ?>
        <?php endif; ?>
    </section>
</article>
<?php include theme_file('foot.php'); ?>
