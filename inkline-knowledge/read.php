<?php include theme_file('head.php'); ?>
<?php
$post = $singlePost;
$postUrl = site_absolute_url('/read/' . (int)$post['id'] . '.html');
$categoryName = Blog::categoryName($post['category_id']);
$postTags = Blog::tagRowsFromKeys($post['tag_keys'] ?? '');
$all = Blog::publishedPostIds();
$idx = array_search($post['id'], $all, true);
$prevPost = $idx !== false && isset($all[$idx + 1]) ? table('posts')->find($all[$idx + 1], 'title') : null;
$nextPost = $idx !== false && isset($all[$idx - 1]) ? table('posts')->find($all[$idx - 1], 'title') : null;
$locked = post_is_protected($post) && !post_access_granted($post);
$summary = trim((string)($post['summary'] ?: excerpt_text($post['markdown'] ?: $post['html'], 220)));
?>
<article class="doc-layout">
    <aside class="doc-meta" aria-label="文章信息">
        <a href="/sort/<?= (int)$post['category_id'] ?>.html"><?= h($categoryName) ?></a>
        <span>发布 <?= h(display_date($post['created_at'], 'Y-m-d')) ?></span>
        <span>更新 <?= h(display_date($post['updated_at'], 'Y-m-d')) ?></span>
        <span><?= (int)$post['views'] ?> 次阅读</span>
        <?php if ($postTags): ?>
            <div class="doc-tags">
                <?php foreach ($postTags as $tagItem): ?>
                    <a href="/tags/<?= (int)$tagItem['id'] ?>.html"><?= h($tagItem['name']) ?></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </aside>
    <div class="doc-main">
        <header class="doc-hero">
            <p class="eyebrow">Document</p>
            <h1><?= h($post['title']) ?></h1>
            <p>作者：<?= h($post['author_name'] ?: 'admin') ?></p>
        </header>
        <div class="read-content">
            <?php if ($locked): ?>
                <?php if ($msg = flash()): ?><div class="notice"><?= h($msg) ?></div><?php endif; ?>
                <div class="protected-summary"><?= h($summary ?: '这篇文章需要输入访问密码后才能阅读全文。') ?></div>
                <form method="post" class="post-password-form">
                    <input type="hidden" name="_csrf" value="<?= h(csrf_token()) ?>">
                    <input type="hidden" name="form" value="post_password">
                    <input type="hidden" name="post_id" value="<?= (int)$post['id'] ?>">
                    <label class="sr-only" for="postPassword">文章访问密码</label>
                    <input id="postPassword" type="password" name="post_password" placeholder="请输入文章访问密码" required>
                    <button type="submit">阅读全文</button>
                </form>
            <?php else: ?>
                <?php if ($msg = flash()): ?><div class="notice"><?= h($msg) ?></div><?php endif; ?>
                <?= optimize_content_images(ensure_image_alt($post['html'] ?: Markdown::render($post['markdown']), $post['title'])) ?>
                <div class="copyright-box">
                    <p>非特殊说明，本文版权归 <?= h($post['author_name'] ?: 'admin') ?> 所有，转载请注明出处。</p>
                    <p>本文标题：<?= h($post['title']) ?></p>
                    <p>本文网址：<a href="<?= h($postUrl) ?>"><?= h($postUrl) ?></a></p>
                </div>
                <nav class="post-neighbor" aria-label="上一篇和下一篇">
                    <div><span>上一篇</span><?= $prevPost ? '<a href="/read/' . (int)$prevPost['id'] . '.html">' . h($prevPost['title']) . '</a>' : '<em>没有了</em>' ?></div>
                    <div><span>下一篇</span><?= $nextPost ? '<a href="/read/' . (int)$nextPost['id'] . '.html">' . h($nextPost['title']) . '</a>' : '<em>没有了</em>' ?></div>
                </nav>
            <?php endif; ?>
        </div>
        <?php if (!$locked): ?>
            <?php include theme_file('comment.php'); ?>
        <?php endif; ?>
    </div>
    <aside class="doc-outline" aria-label="阅读辅助">
        <strong>阅读路径</strong>
        <a href="/">知识库首页</a>
        <a href="/sort/<?= (int)$post['category_id'] ?>.html"><?= h($categoryName) ?></a>
        <a href="#comments">评论</a>
    </aside>
</article>
<?php include theme_file('foot.php'); ?>
