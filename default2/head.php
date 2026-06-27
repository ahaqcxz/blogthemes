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
if (!empty($seo['prev'])) {
    $pageLinkLines[] = '<link rel="prev" href="' . h($seo['prev']) . '">';
}
if (!empty($seo['next'])) {
    $pageLinkLines[] = '<link rel="next" href="' . h($seo['next']) . '">';
}
$ogImageLines = [];
if (!empty($seo['image'])) {
    $ogImageLines[] = '<meta property="og:image" content="' . h($seo['image']) . '">';
}
$twitterLines = [
    '<meta name="twitter:card" content="' . (!empty($seo['image']) ? 'summary_large_image' : 'summary') . '">',
    '<meta name="twitter:title" content="' . h($seo['title']) . '">',
    '<meta name="twitter:description" content="' . h($seo['description']) . '">',
];
if (!empty($seo['image'])) {
    $twitterLines[] = '<meta name="twitter:image" content="' . h($seo['image']) . '">';
}
$schemaLines = [];
foreach (($seo['schema'] ?? []) as $schemaItem) {
    $schemaLines[] = '<script type="application/ld+json">' . json_encode($schemaItem, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}
$logoText = (string)($site['logo_text'] ?? '');
$logoHtml = str_starts_with($logoText, 'Na')
    ? '<span class="logo-accent">Na</span>' . h(substr($logoText, 2))
    : h($logoText);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width">
    <meta name="author" content="admin">
    <meta name="robots" content="<?= h($seo['robots']) ?>">
    <title><?= h($seo['title']) ?></title>
    <meta name="keywords" content="<?= h($seo['keywords']) ?>">
    <meta name="description" content="<?= h($seo['description']) ?>">
    <meta name="referrer" content="no-referrer">
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
<?= site_background_style('light') ?>
</head>
<body>
<div class="page-bg"></div>
<header class="gird-header">
    <div class="header-fixed">
        <div class="header-inner">
            <a href="/" class="header-logo" id="logo"><?= $logoHtml ?></a>
            <nav class="nav" id="nav">
                <ul>
                    <li id="minisearch"><div class="mini-search-wrap"><input type="text" id="keywords" placeholder="输入关键字搜索" onkeypress="if(event.keyCode==13){siteSearch('keywords')}"><button type="button" class="search-submit" aria-label="搜索" onclick="siteSearch('keywords')"></button></div></li>
                    <li class="<?= $path === '/' ? 'current' : '' ?>"><a href="/">首页</a></li>
                    <?php foreach (Blog::categories() as $navCategory): ?>
                        <li class="<?= $category && (int)$category['id'] === (int)$navCategory['id'] ? 'current' : '' ?>"><a href="/sort/<?= (int)$navCategory['id'] ?>.html"><?= h($navCategory['name']) ?></a></li>
                    <?php endforeach; ?>
                    <li class="<?= !empty($linksPage) ? 'current' : '' ?>"><a href="/links.html">友链导航</a></li>
                    <li class="<?= $messageBoard ? 'current' : '' ?>"><a href="/bbs.html">留言板</a></li>
                </ul>
            </nav>
            <button class="phone-menu" type="button" onclick="document.getElementById('nav').classList.toggle('open')"><i></i><i></i><i></i></button>
        </div>
    </div>
</header>
<main class="doc-container">
    <div class="container-fixed">
        <div class="col-content">
            <div class="inner">
