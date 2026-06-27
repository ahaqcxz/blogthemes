<article class="holo-card enter">
    <a class="card-image" href="/read/<?= (int)$post['id'] ?>.html">
        <img src="<?= h(post_cover_url($post)) ?>" alt="<?= h($post['title']) ?>" loading="lazy">
    </a>
    <div>
        <div class="card-meta">
            <a href="/sort/<?= (int)$post['category_id'] ?>.html"><?= h(Blog::categoryName($post['category_id'])) ?></a>
            <time><?= h(display_date($post['created_at'], 'Y-m-d')) ?></time>
            <span><?= (int)$post['views'] ?> 次阅读</span>
        </div>
        <h2><a href="/read/<?= (int)$post['id'] ?>.html"><?= h($post['title']) ?></a></h2>
        <p><?= h($post['summary'] ?: excerpt_text($post['markdown'] ?: $post['html'], 150)) ?></p>
    </div>
</article>
