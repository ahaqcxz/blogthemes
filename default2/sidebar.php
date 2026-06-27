<aside class="col-other">
    <div class="inner">
        <div class="other-item" id="categoryandsearch">
            <div class="search">
                <label class="search-wrap">
                    <input type="text" id="keyword" placeholder="输入关键字搜索" onkeypress="if(event.keyCode==13){siteSearch('keyword')}">
                    <button type="button" class="search-icon search-submit" aria-label="搜索" onclick="siteSearch('keyword')"></button>
                </label>
            </div>
        </div>
        <div class="other-item">
            <h5 class="other-item-title">热门文章</h5>
            <div class="inner"><ul class="hot-list-article">
                <?php foreach (Blog::hotPosts() as $hot): ?><li><a href="/read/<?= (int)$hot['id'] ?>.html"><?= h($hot['title']) ?></a></li><?php endforeach; ?>
            </ul></div>
        </div>
        <div class="other-item">
            <h5 class="other-item-title">最新文章</h5>
            <div class="inner"><ul class="hot-list-article">
                <?php foreach (Blog::latestPosts() as $latest): ?><li><a href="/read/<?= (int)$latest['id'] ?>.html"><?= h($latest['title']) ?></a></li><?php endforeach; ?>
            </ul></div>
        </div>
        <div class="other-item">
            <h5 class="other-item-title">标签云</h5>
            <div class="inner"><div class="tag-cloud">
                <?php foreach (Blog::tags() as $sideTag): ?><a href="/tags/<?= (int)$sideTag['id'] ?>.html"><?= h($sideTag['name']) ?></a><?php endforeach; ?>
            </div></div>
        </div>
        <?php $siteStats = Blog::siteStats(); ?>
        <div class="other-item">
            <h5 class="other-item-title">网站资讯</h5>
            <div class="inner">
                <dl class="site-stats">
                    <div><dt>文章数目</dt><dd><?= (int)$siteStats['article_count'] ?></dd></div>
                    <div><dt>已运行时间</dt><dd><?= (int)$siteStats['running_days'] ?> 天</dd></div>
                    <div><dt>本站总访问量</dt><dd><?= (int)$siteStats['total_views'] ?></dd></div>
                    <div><dt>最近更新时间</dt><dd><?= h($siteStats['last_updated_display']) ?></dd></div>
                </dl>
            </div>
        </div>
    </div>
</aside>
