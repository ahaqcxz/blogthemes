</main>
<footer class="atlas-footer">
    <div class="atlas-wrap footer-inner">
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
            <a href="/links.html">友链</a>
            <a href="/bbs.html">留言</a>
            <a href="/rss.xml" target="_blank">RSS</a>
            <?php if (!empty($site['footer_link_text'])): ?>
                <a href="<?= h($site['footer_link_url']) ?>" target="_blank" rel="noopener"><?= h($site['footer_link_text']) ?></a>
            <?php endif; ?>
        </nav>
        <form class="footer-search" onsubmit="siteSearch('atlasFooterKeyword');return false;">
            <label class="sr-only" for="atlasFooterKeyword">搜索文章</label>
            <input id="atlasFooterKeyword" placeholder="搜索文章、分类或标签">
            <button type="submit">搜索</button>
        </form>
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
