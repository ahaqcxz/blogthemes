<aside class="sidebar">
    <section class="side-box side-search-panel">
        <form class="side-search" onsubmit="siteSearch('sideKeyword');return false;">
            <input id="sideKeyword" placeholder="搜索文章">
            <button type="submit">搜索</button>
        </form>
    </section>
    <section class="side-box">
        <h3>最新文章</h3>
        <ul class="side-list">
            <?php foreach (Blog::latestPosts() as $latest): ?><li><a href="/read/<?= (int)$latest['id'] ?>.html"><?= h($latest['title']) ?></a></li><?php endforeach; ?>
        </ul>
    </section>
    <section class="side-box">
        <h3>热门文章</h3>
        <ul class="side-list">
            <?php foreach (Blog::hotPosts() as $hot): ?><li><a href="/read/<?= (int)$hot['id'] ?>.html"><?= h($hot['title']) ?></a></li><?php endforeach; ?>
        </ul>
    </section>
    <section class="side-box">
        <h3>标签</h3>
        <div class="tag-cloud">
            <?php foreach (Blog::tags() as $sideTag): ?><a href="/tags/<?= (int)$sideTag['id'] ?>.html"><?= h($sideTag['name']) ?></a><?php endforeach; ?>
        </div>
    </section>
    <?php $siteStats = Blog::siteStats(); ?>
    <section class="side-box">
        <h3>站点</h3>
        <dl class="site-stats">
            <div><dt>文章</dt><dd><?= (int)$siteStats['article_count'] ?></dd></div>
            <div><dt>运行</dt><dd><?= (int)$siteStats['running_days'] ?> 天</dd></div>
            <div><dt>访问</dt><dd><?= (int)$siteStats['total_views'] ?></dd></div>
            <div><dt>最近更新</dt><dd><?= h($siteStats['last_updated_display']) ?></dd></div>
        </dl>
    </section>
</aside>
