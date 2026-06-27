<aside class="sidebar" aria-label="侧边栏">
    <section class="side-box side-search-panel">
        <p class="side-label">站内检索</p>
        <form class="side-search" onsubmit="siteSearch('sideKeyword');return false;">
            <label class="sr-only" for="sideKeyword">搜索文章</label>
            <input id="sideKeyword" placeholder="搜索文章">
            <button type="submit">搜索</button>
        </form>
    </section>
    <section class="side-box">
        <h3>栏目索引</h3>
        <div class="category-index">
            <?php foreach (Blog::categories() as $sideCategory): ?>
                <a href="/sort/<?= (int)$sideCategory['id'] ?>.html"><span><?= h($sideCategory['name']) ?></span><em><?= count(Blog::postsByCategory((int)$sideCategory['id'])) ?></em></a>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="side-box">
        <h3>热门文章</h3>
        <ol class="rank-list"><?php foreach (Blog::hotPosts() as $hotIndex => $hot): ?><li><a href="/read/<?= (int)$hot['id'] ?>.html"><span><?= (int)$hotIndex + 1 ?></span><?= h($hot['title']) ?></a></li><?php endforeach; ?></ol>
    </section>
    <section class="side-box">
        <h3>标签</h3>
        <div class="tag-cloud"><?php foreach (Blog::tags() as $sideTag): ?><a href="/tags/<?= (int)$sideTag['id'] ?>.html"><?= h($sideTag['name']) ?></a><?php endforeach; ?></div>
    </section>
    <?php $siteStats = Blog::siteStats(); ?>
    <section class="side-box">
        <h3>站点信息</h3>
        <dl class="site-stats">
            <div><dt>文章</dt><dd><?= (int)$siteStats['article_count'] ?></dd></div>
            <div><dt>运行</dt><dd><?= (int)$siteStats['running_days'] ?> 天</dd></div>
            <div><dt>访问</dt><dd><?= (int)$siteStats['total_views'] ?></dd></div>
            <div><dt>最近更新</dt><dd><?= h($siteStats['last_updated_display']) ?></dd></div>
        </dl>
    </section>
</aside>
