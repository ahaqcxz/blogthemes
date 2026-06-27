<?php include theme_file('head.php'); ?>
<section class="empty-panel reveal">
    <p class="panel-kicker">SYSTEM_ERROR</p>
    <h1><?= h($errorTitle ?? '页面不存在') ?></h1>
    <p><?= h($errorMessage ?? '请求的内容暂时无法访问。') ?></p>
    <?php if (!empty($errorHint)): ?><p><?= h($errorHint) ?></p><?php endif; ?>
    <a class="cyber-button" href="/">RETURN HOME</a>
</section>
<?php include theme_file('foot.php'); ?>
