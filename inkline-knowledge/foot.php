</main>
<footer class="ink-footer">
    <div class="ink-wrap footer-inner">
        <div>
            <strong><?= h($site['site_name'] ?? '我的博客') ?></strong>
            <?php if (!empty($site['motto'])): ?><p><?= h($site['motto']) ?></p><?php endif; ?>
            <?php if (!empty($site['copyright'])): ?><p><?= h($site['copyright']) ?></p><?php endif; ?>
            <?php if (!empty($site['beian_text'])): ?>
                <p><a href="<?= h($site['beian_url'] ?: 'https://beian.miit.gov.cn/') ?>" target="_blank" rel="nofollow noopener"><?= h($site['beian_text']) ?></a></p>
            <?php endif; ?>
        </div>
        <nav aria-label="页脚导航">
            <a href="/">首页</a>
            <a href="/list/1.html">文章索引</a>
            <a href="/links.html">友链</a>
            <a href="/bbs.html">留言</a>
            <a href="/rss.xml" target="_blank">RSS</a>
        </nav>
    </div>
</footer>
<script>
function siteSearch(id) {
    var input = document.getElementById(id);
    var keyword = input ? input.value.trim() : '';
    location.href = keyword ? '/search/' + encodeURIComponent(keyword) + '.html' : '/';
}
</script>
<?php if (!empty($site['analytics_code'])): ?>
<?= $site['analytics_code'] . "\n" ?>
<?php endif; ?>
</body>
</html>
