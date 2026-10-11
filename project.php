<?php
require __DIR__ . '/includes/bootstrap.php';

$slug = is_string($_GET['p'] ?? null) ? $_GET['p'] : '';
$p = $slug !== '' ? project_find($slug) : null;
if (!$p || empty($p['published'])) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$brand = $p['brand'];
$cover = project_cover($p);
$page = [
    'title'  => $p['title'] . ' | ' . company($brand)['short'],
    'desc'   => $p['summary'] ?: ($p['title'] . ', a project by ' . company($brand)['name'] . '.'),
    'brand'  => $brand,
    'active' => $brand === 'ants' ? 'ants-portfolio' : 'portfolio',
    'path'   => 'project.php?p=' . rawurlencode($p['slug']),
    'image'  => $cover ? SITE_URL . '/' . $cover['src'] : null,
];

// Previous / next within the same brand
$siblings = projects_published($brand);
$prev = $next = null;
foreach ($siblings as $i => $s) {
    if ($s['id'] === $p['id']) {
        $prev = $siblings[$i - 1] ?? null;
        $next = $siblings[$i + 1] ?? null;
        break;
    }
}
$back = $brand === 'ants' ? url('ants/portfolio.php') : url('portfolio.php');
$meta = array_filter([
    'Category' => $p['category'] ?? '',
    'Location' => $p['location'] ?? '',
    'Year'     => $p['year'] ?? '',
    'Client'   => $p['client'] ?? '',
]);
require __DIR__ . '/includes/header.php';
?>

<section class="project-hero">
  <div class="container">
    <div class="crumbs"><a href="<?= $back ?>">Portfolio</a> &nbsp;/&nbsp; <?= e($p['title']) ?></div>
    <span class="eyebrow"><?= e(company($brand)['short']) ?><?= !empty($p['sample']) ? ' · Sample project' : '' ?></span>
    <h1><?= e($p['title']) ?></h1>
    <?php if ($meta): ?>
      <dl class="project-hero__meta">
        <?php foreach ($meta as $k => $v): ?><div><dt><?= e($k) ?></dt><dd><?= e($v) ?></dd></div><?php endforeach; ?>
      </dl>
    <?php endif; ?>
  </div>
</section>

<?php if ($cover): ?>
  <div class="container"><img class="project-cover" src="<?= e(img_url($cover)) ?>" alt="<?= e($p['title']) ?>"></div>
<?php endif; ?>

<div class="container">
  <div class="project-body">
    <div>
      <?php if (!empty($p['summary'])): ?><p class="summary"><?= e($p['summary']) ?></p><?php endif; ?>
    </div>
    <div>
      <?php if (!empty($p['description'])): ?><div class="desc"><?= e($p['description']) ?></div><?php endif; ?>
      <p style="margin-top:32px"><a class="btn btn--dark" href="<?= url($brand === 'ants' ? 'ants/#contact' : 'contact.php') ?>">Discuss a similar project <?= icon('arrow') ?></a></p>
    </div>
  </div>

  <?php $gallery = array_slice($p['images'] ?? [], 1); if ($gallery): ?>
    <div class="gallery">
      <?php foreach ($gallery as $img): ?>
        <a href="<?= e(img_url($img)) ?>" data-lightbox><img src="<?= e(img_url($img, 'thumb')) ?>" alt="<?= e($p['title']) ?>" loading="lazy"></a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <nav class="pn" aria-label="More projects" style="margin-top:72px">
    <?php if ($prev): ?>
      <a href="<?= url('project.php?p=' . rawurlencode($prev['slug'])) ?>"><small>&larr; Previous</small><span><?= e($prev['title']) ?></span></a>
    <?php else: ?>
      <a href="<?= $back ?>"><small>&larr; Back</small><span>All projects</span></a>
    <?php endif; ?>
    <?php if ($next): ?>
      <a href="<?= url('project.php?p=' . rawurlencode($next['slug'])) ?>"><small>Next &rarr;</small><span><?= e($next['title']) ?></span></a>
    <?php else: ?>
      <a href="<?= $back ?>"><small>Portfolio &rarr;</small><span>All projects</span></a>
    <?php endif; ?>
  </nav>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
