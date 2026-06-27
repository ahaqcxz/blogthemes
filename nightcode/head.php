<?php
$site = $settings;
$seo = array_merge([
    'title' => $title,
    'keywords' => $site['keywords'] ?? '',
    'description' => $site['description'] ?? '',
    'canonical' => site_absolute_url(page_canonical_path($path ?? '/')),
    'robots' => 'index,follow',
    'image' => '',
    'type' => 'website',
    'prev' => '',
    'next' => '',
    'schema' => [],
], $seo ?? []);
$pageLinkLines = [];
if (!empty($seo['prev'])) $pageLinkLines[] = '<link rel="prev" href="' . h($seo['prev']) . '">';
if (!empty($seo['next'])) $pageLinkLines[] = '<link rel="next" href="' . h($seo['next']) . '">';
$ogImageLines = [];
if (!empty($seo['image'])) $ogImageLines[] = '<meta property="og:image" content="' . h($seo['image']) . '">';
$twitterLines = [
    '<meta name="twitter:card" content="' . (!empty($seo['image']) ? 'summary_large_image' : 'summary') . '">',
    '<meta name="twitter:title" content="' . h($seo['title']) . '">',
    '<meta name="twitter:description" content="' . h($seo['description']) . '">',
];
if (!empty($seo['image'])) $twitterLines[] = '<meta name="twitter:image" content="' . h($seo['image']) . '">';
$schemaLines = [];
foreach (($seo['schema'] ?? []) as $schemaItem) {
    $schemaLines[] = '<script type="application/ld+json">' . json_encode($schemaItem, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}
$logoText = trim((string)($site['logo_text'] ?? '')) ?: ($site['site_name'] ?? '我的博客');
?>
<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="admin">
    <meta name="robots" content="<?= h($seo['robots']) ?>">
    <title><?= h($seo['title']) ?></title>
    <meta name="keywords" content="<?= h($seo['keywords']) ?>">
    <meta name="description" content="<?= h($seo['description']) ?>">
    <meta name="referrer" content="no-referrer">
    <meta name="color-scheme" content="dark">
    <link rel="icon" href="<?= h(static_asset_storage_url('/favicon.svg')) ?>" type="image/svg+xml">
    <link rel="shortcut icon" href="<?= h(static_asset_storage_url('/favicon.svg')) ?>" type="image/svg+xml">
    <link rel="apple-touch-icon" href="<?= h(static_asset_storage_url('/favicon.svg')) ?>">
    <link rel="canonical" href="<?= h($seo['canonical']) ?>">
<?= $pageLinkLines ? '    ' . implode("\n    ", $pageLinkLines) . "\n" : '' ?>
    <link rel="alternate" type="application/rss+xml" title="<?= h($site['site_name']) ?> RSS" href="<?= h(site_absolute_url('/rss.xml')) ?>">
    <meta property="og:locale" content="zh_CN">
    <meta property="og:site_name" content="<?= h($site['site_name']) ?>">
    <meta property="og:type" content="<?= h($seo['type']) ?>">
    <meta property="og:title" content="<?= h($seo['title']) ?>">
    <meta property="og:description" content="<?= h($seo['description']) ?>">
    <meta property="og:url" content="<?= h($seo['canonical']) ?>">
<?= $ogImageLines ? '    ' . implode("\n    ", $ogImageLines) . "\n" : '' ?>
<?= '    ' . implode("\n    ", $twitterLines) . "\n" ?>
    <link rel="stylesheet" href="<?= h(theme_asset('assets/css/style.css')) ?>">
<?= $schemaLines ? '    ' . implode("\n    ", $schemaLines) . "\n" : '' ?>
<?= site_background_style('dark') ?>
</head>
<body>
<a class="skip-link" href="#main">跳到正文</a>
<header class="site-header">
    <div class="site-wrap header-inner">
        <a class="site-logo" href="/"><span>&gt;_</span><strong><?= h($logoText) ?></strong></a>
        <button class="nav-toggle" type="button" onclick="document.getElementById('siteNav').classList.toggle('is-open')" aria-label="打开导航"><span></span><span></span><span></span></button>
        <nav class="site-nav" id="siteNav" aria-label="主导航">
            <a class="<?= $path === '/' ? 'is-active' : '' ?>" href="/">首页</a>
            <?php foreach (Blog::categories() as $navCategory): ?>
                <a class="<?= $category && (int)$category['id'] === (int)$navCategory['id'] ? 'is-active' : '' ?>" href="/sort/<?= (int)$navCategory['id'] ?>.html"><?= h($navCategory['name']) ?></a>
            <?php endforeach; ?>
            <a class="<?= !empty($linksPage) ? 'is-active' : '' ?>" href="/links.html">友链</a>
            <a class="<?= $messageBoard ? 'is-active' : '' ?>" href="/bbs.html">留言</a>
            <form class="mobile-search" onsubmit="siteSearch('nightMobileKeyword');return false;">
                <label class="sr-only" for="nightMobileKeyword">搜索文章</label>
                <input id="nightMobileKeyword" placeholder="grep articles">
                <button type="submit">RUN</button>
            </form>
        </nav>
    </div>
</header>
<main class="site-main site-wrap" id="main">
    <section class="content-area">
