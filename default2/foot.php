            </div>
        </div>
        <?php include theme_file('sidebar.php'); ?>
    </div>
</main>
<footer class="grid-footer">
    <div class="footer-fixed">
        <div class="copyright">
            <div class="info">
                <?php if (!empty($site['footer_link_text'])): ?>
                    <a href="<?= h($site['footer_link_url']) ?>" class="footer-link" target="_blank"><?= h($site['footer_link_text']) ?></a>
                <?php endif; ?>
                <p><?= h($site['motto']) ?></p>
                <p><?= h($site['copyright']) ?><br>PHP执行时间：<?= h(number_format(microtime(true) - ($_SERVER['REQUEST_TIME_FLOAT'] ?? microtime(true)), 6)) ?> 秒</p>
                <?php if (!empty($site['beian_text'])): ?>
                    <p class="beian">
                        <a href="<?= h($site['beian_url'] ?: 'https://beian.miit.gov.cn/') ?>" target="_blank" rel="nofollow noopener"><?= h($site['beian_text']) ?></a>
                    </p>
                <?php endif; ?>
                <p class="rss-link"><a href="/rss.xml" target="_blank">RSS订阅</a></p>
            </div>
        </div>
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
