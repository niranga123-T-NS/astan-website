<?php
defined('APP') or exit;
/**
 * Expects $page = [
 *   'title' => ..., 'desc' => ..., 'brand' => 'astan'|'ants', 'active' => nav key,
 *   'path' => canonical path, 'image' => optional share image URL, 'class' => optional body class
 * ];
 */
$brand  = $page['brand'] ?? 'astan';
$co     = company($brand);
$active = $page['active'] ?? '';
$share  = $page['image'] ?? SITE_URL . '/assets/img/share-' . $brand . '.png';

$nav = $brand === 'ants'
    ? ['ants' => ['ants/', 'Studio'], 'ants-services' => ['ants/#services', 'Services'], 'ants-portfolio' => ['ants/portfolio.php', 'Portfolio'], 'ants-process' => ['ants/#process', 'Process'], 'ants-contact' => ['ants/#contact', 'Contact']]
    : ['home' => ['', 'Home'], 'about' => ['about.php', 'About'], 'services' => ['services.php', 'Services'], 'portfolio' => ['portfolio.php', 'Portfolio'], 'ants' => ['ants/', 'ANTS Design'], 'contact' => ['contact.php', 'Contact']];
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($page['title']) ?></title>
  <meta name="description" content="<?= e($page['desc']) ?>">
  <link rel="canonical" href="<?= e(SITE_URL . '/' . ltrim($page['path'] ?? '', '/')) ?>">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="<?= e($co['name']) ?>">
  <meta property="og:title" content="<?= e($page['title']) ?>">
  <meta property="og:description" content="<?= e($page['desc']) ?>">
  <meta property="og:image" content="<?= e($share) ?>">
  <meta name="theme-color" content="<?= $brand === 'ants' ? '#f7f3ec' : '#0f1d38' ?>">
  <link rel="icon" href="<?= url($brand === 'ants' ? 'assets/img/ants-favicon.svg' : 'assets/img/favicon.svg') ?>" type="image/svg+xml">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,500&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= url('assets/css/site.css') ?>?v=2">
  <script type="application/ld+json"><?= json_encode([
      '@context' => 'https://schema.org',
      '@type' => 'Organization',
      'name' => $co['name'],
      'url' => 'https://' . $co['web'],
      'email' => $co['email'],
      'telephone' => PHONES[0],
      'address' => ['@type' => 'PostalAddress', 'streetAddress' => '318/4D, Sirinanda Jothikarama Road', 'addressLocality' => 'Thalawathugoda', 'addressCountry' => 'LK'],
  ] + ($brand === 'ants' ? ['parentOrganization' => ['@type' => 'Organization', 'name' => COMPANIES['astan']['name']]] : []), JSON_UNESCAPED_SLASHES) ?></script>
</head>
<body class="theme-<?= e($brand) ?> <?= e($page['class'] ?? '') ?>">
  <a class="skip" href="#main">Skip to content</a>
  <header class="site-header" data-header>
    <div class="container header-inner">
      <?php if ($brand === 'ants'): ?>
        <a class="brand brand--ants" href="<?= url('ants/') ?>" aria-label="ANTS Design Ventures home">
          <img src="<?= url('assets/img/ants-logo.svg') ?>" alt="" width="58" height="49">
          <span class="brand__text"><span class="brand__name">ANTS</span><span class="brand__sub">Design Ventures</span></span>
        </a>
      <?php else: ?>
        <a class="brand" href="<?= url() ?>" aria-label="ASTAN International home">
          <img src="<?= url('assets/img/logo-mark.svg') ?>" alt="" width="44" height="44">
          <span class="brand__text"><span class="brand__name">ASTAN</span><span class="brand__sub">International (Pvt) Ltd</span></span>
        </a>
      <?php endif; ?>

      <nav class="nav" id="site-nav" aria-label="Main">
        <ul>
          <?php foreach ($nav as $key => [$href, $label]): ?>
            <li><a href="<?= url($href) ?>"<?= $key === $active ? ' aria-current="page"' : '' ?>><?= e($label) ?></a></li>
          <?php endforeach; ?>
        </ul>
        <div class="nav__extra">
          <?php if ($brand === 'ants'): ?>
            <a class="nav__parent" href="<?= url() ?>">An ASTAN International company &rarr;</a>
          <?php endif; ?>
          <a class="btn btn--accent btn--sm" href="<?= url($brand === 'ants' ? 'ants/#contact' : 'contact.php') ?>"><?= $brand === 'ants' ? 'Start a project' : 'Get a quote' ?></a>
        </div>
      </nav>
      <button class="nav-toggle" aria-label="Menu" aria-expanded="false" aria-controls="site-nav"><span></span><span></span></button>
    </div>
  </header>
  <main id="main">
