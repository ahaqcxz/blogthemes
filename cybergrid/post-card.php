<article class="stream-card reveal">
    <a class="stream-cover" href="/read/<?= (int)$post['id'] ?>.html">
        <img src="<?= h(post_cover_url($post)) ?>" alt="<?= h($post['title']) ?>" loading="lazy">
    </a>
    <div class="stream-body">
        <div class="stream-meta">
            <span>#<?= str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <a href="/sort/<?= (int)($post['category_id'] ?? 0) ?>.html"><?= h(Blog::categoryName($post['category_id'] ?? 0)) ?></a>
            <time><?= h(display_date($post['created_at'], 'Y-m-d')) ?></time>
            <span><?= (int)($post['views'] ?? 0) ?> reads</span>
        </div>
        <h2><a href="/read/<?= (int)$post['id'] ?>.html"><?= h($post['title']) ?></a></h2>
        <p><?= h(($post['summary'] ?? '') ?: excerpt_text(($post['markdown'] ?? '') ?: ($post['html'] ?? ''), 150)) ?></p>
    </div>
</article>
