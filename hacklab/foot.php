    </section>
    <?php include theme_file('sidebar.php'); ?>
</main>
<footer class="site-footer">
    <div class="site-wrap footer-inner">
        <div class="footer-console">
            <span>$ uptime</span>
            <span>response <?= h(number_format(microtime(true) - ($_SERVER['REQUEST_TIME_FLOAT'] ?? microtime(true)), 6)) ?>s</span>
            <a href="/rss.xml" target="_blank">rss.xml</a>
        </div>
        <?php if (!empty($site['footer_link_text'])): ?><p><a href="<?= h($site['footer_link_url']) ?>" target="_blank" rel="noopener"><?= h($site['footer_link_text']) ?></a></p><?php endif; ?>
        <?php if (!empty($site['motto'])): ?><p><?= h($site['motto']) ?></p><?php endif; ?>
        <?php if (!empty($site['copyright'])): ?><p><?= h($site['copyright']) ?></p><?php endif; ?>
        <?php if (!empty($site['beian_text'])): ?><p><a href="<?= h($site['beian_url'] ?: 'https://beian.miit.gov.cn/') ?>" target="_blank" rel="nofollow noopener"><?= h($site['beian_text']) ?></a></p><?php endif; ?>
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
