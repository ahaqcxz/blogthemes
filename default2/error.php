<?php include theme_file('head.php'); ?>
<article class="article-list">
    <section class="article-item site-error">
        <div class="error-mark">!</div>
        <p class="error-kicker">内容暂时不可用</p>
        <h4><?= h($errorTitle ?: '页面不存在') ?></h4>
        <p class="error-message"><?= h($errorMessage ?: '你访问的内容不存在，请返回首页继续浏览。') ?></p>
        <?php if (!empty($errorHint)): ?>
            <p class="error-hint"><?= h($errorHint) ?></p>
        <?php endif; ?>
        <div class="error-actions">
            <a class="error-btn" href="/">返回首页</a>
            <a class="error-link" href="javascript:history.back()">返回上一页</a>
            <a class="error-link" href="/bbs.html">去留言板</a>
        </div>
    </section>
</article>
<?php include theme_file('foot.php'); ?>
