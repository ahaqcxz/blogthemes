<aside class="sidebar" aria-label="侧边栏">
    <section class="side-box side-search-panel">
        <p class="side-label">query</p>
        <form class="side-search" onsubmit="siteSearch('sideKeyword');return false;">
            <label class="sr-only" for="sideKeyword">搜索文章</label>
            <input id="sideKeyword" placeholder="grep articles">
            <button type="submit">RUN</button>
        </form>
    </section>
    <section class="side-box">
        <h3>recent.log</h3>
        <ul class="side-list"><?php foreach (Blog::latestPosts() as $latest): ?><li><a href="/read/<?= (int)$latest['id'] ?>.html"><?= h($latest['title']) ?></a></li><?php endforeach; ?></ul>
    </section>
    <section class="side-box">
        <h3>hot.paths</h3>
        <ul class="side-list"><?php foreach (Blog::hotPosts() as $hot): ?><li><a href="/read/<?= (int)$hot['id'] ?>.html"><?= h($hot['title']) ?></a></li><?php endforeach; ?></ul>
    </section>
    <section class="side-box">
        <h3>tags</h3>
        <div class="tag-cloud"><?php foreach (Blog::tags() as $sideTag): ?><a href="/tags/<?= (int)$sideTag['id'] ?>.html">#<?= h($sideTag['name']) ?></a><?php endforeach; ?></div>
    </section>
    <?php $siteStats = Blog::siteStats(); ?>
    <section class="side-box">
        <h3>runtime</h3>
        <dl class="site-stats">
            <div><dt>posts</dt><dd><?= (int)$siteStats['article_count'] ?></dd></div>
            <div><dt>uptime</dt><dd><?= (int)$siteStats['running_days'] ?>d</dd></div>
            <div><dt>views</dt><dd><?= (int)$siteStats['total_views'] ?></dd></div>
            <div><dt>updated</dt><dd><?= h($siteStats['last_updated_display']) ?></dd></div>
        </dl>
    </section>
</aside>
