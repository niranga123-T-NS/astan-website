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

  <?php
  $stages = project_stages($p);
  $staged = $stages['before'] || $stages['design'] || $stages['after'];
  // General photos: the cover is already shown above, so leave it out here.
  $general = array_values(array_filter($stages[''], fn($img) => !$cover || $img['src'] !== $cover['src']));
  $sections = [];
  foreach (['before' => 'The space before work started.', 'design' => 'Concepts, drawings and visualisations.', 'after' => 'The finished space.'] as $k => $intro) {
      if ($stages[$k]) {
          $sections[$k] = [STAGES[$k], $intro, $stages[$k]];
      }
  }
  if ($general) {
      $sections['more'] = [$staged ? 'More photos' : '', '', $general];
  }
  ?>
  <?php if ($staged): ?>
    <nav class="stage-nav" aria-label="Project stages">
      <?php foreach ($sections as $k => [$label]): if ($label === '') continue; ?>
        <a href="#stage-<?= e($k) ?>" class="stage-nav__<?= e($k) ?>"><?= e($label) ?> <span><?= count($sections[$k][2]) ?></span></a>
      <?php endforeach; ?>
    </nav>
  <?php endif; ?>

  <?php if ($stages['before'] && $stages['after']):
      $b = $stages['before'][0];
      // Compare against an After photo other than the cover (already shown above), if there is one.
      $afterAlt = array_values(array_filter($stages['after'], fn($img) => !$cover || $img['src'] !== $cover['src']));
      $a = $afterAlt[0] ?? $stages['after'][0]; ?>
    <section class="compare-wrap">
      <h2 class="stage-title">Before &amp; after</h2>
      <p class="stage-intro">Drag the handle to compare.</p>
      <div class="compare" data-compare style="--pos:50%">
        <img src="<?= e(img_url($a)) ?>" alt="<?= e($p['title']) ?>: after">
        <div class="compare__before"><img src="<?= e(img_url($b)) ?>" alt="<?= e($p['title']) ?>: before"></div>
        <span class="compare__label compare__label--before">Before</span>
        <span class="compare__label compare__label--after">After</span>
        <span class="compare__handle" aria-hidden="true"></span>
        <input type="range" min="0" max="100" value="50" aria-label="Compare before and after">
      </div>
    </section>
  <?php endif; ?>

  <?php foreach ($sections as $k => [$label, $intro, $imgs]): ?>
    <section class="stage-section" id="stage-<?= e($k) ?>">
      <?php if ($label !== ''): ?>
        <h2 class="stage-title"><span class="stage-dot stage-dot--<?= e($k) ?>"></span><?= e($label) ?></h2>
        <?php if ($intro): ?><p class="stage-intro"><?= e($intro) ?></p><?php endif; ?>
      <?php endif; ?>
      <div class="gallery">
        <?php foreach ($imgs as $img): ?>
          <a href="<?= e(img_url($img)) ?>" data-lightbox><img src="<?= e(img_url($img, 'thumb')) ?>" alt="<?= e($p['title'] . ($label ? ': ' . $label : '')) ?>" loading="lazy"></a>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endforeach; ?>

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
