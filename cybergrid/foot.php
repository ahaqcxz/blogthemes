    </main>
    <footer class="cyber-footer">
        <div>
            <strong><?= h($settings['site_name'] ?? '我的博客') ?></strong>
            <span><?= h($settings['footer_text'] ?? '') ?></span>
        </div>
        <div class="footer-links">
            <?php if (!empty($settings['footer_link_text']) && !empty($settings['footer_link_url'])): ?>
                <a href="<?= h($settings['footer_link_url']) ?>"><?= h($settings['footer_link_text']) ?></a>
            <?php endif; ?>
            <a href="/rss.xml">RSS</a>
        </div>
    </footer>
</div>
<script>
function siteSearch(inputId) {
    var input = document.getElementById(inputId);
    var keyword = input ? input.value.trim() : '';
    if (keyword) location.href = '/search/' + encodeURIComponent(keyword) + '.html';
}
</script>
</body>
</html>
