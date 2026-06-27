<?php include theme_file('head.php'); ?>
<article class="read-card error-card">
    <p class="command">$ curl current_url</p>
    <div class="error-mark">404</div>
    <h1><?= h($errorTitle ?: '页面不存在') ?></h1>
    <p><?= h($errorMessage ?: '你访问的内容不存在，请返回首页继续浏览。') ?></p>
    <?php if (!empty($errorHint)): ?><p class="muted"><?= h($errorHint) ?></p><?php endif; ?>
    <div class="error-actions">
        <a class="primary-link" href="/">返回首页</a>
        <a href="javascript:history.back()">返回上一页</a>
        <a href="/bbs.html">去留言板</a>
    </div>
</article>
<?php include theme_file('foot.php'); ?>
