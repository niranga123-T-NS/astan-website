<?php
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'  => 'Services | ASTAN International (Pvt) Ltd',
    'desc'   => 'MEP contracts, electrical consultancy, interior design and construction, real estate, investments, import and export of products, and service exports and imports in Sri Lanka.',
    'brand'  => 'astan',
    'active' => 'services',
    'path'   => 'services.php',
];
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero page-hero--dark">
  <div class="container">
    <div class="crumbs"><a href="<?= url() ?>">Home</a> &nbsp;/&nbsp; Services</div>
    <span class="eyebrow">Services</span>
    <h1>Everything your project needs, <em>under one roof</em></h1>
    <p class="lead">Eight services across four divisions, delivered by one coordinated team.</p>
  </div>
</section>

<nav class="svc-nav" aria-label="Services">
  <div class="container">
    <?php foreach (SERVICES as $key => $s): ?>
      <a href="#<?= e($key) ?>"><?= e($s['title']) ?></a>
    <?php endforeach; ?>
  </div>
</nav>

<section class="section" style="padding-top:24px">
  <div class="container">
    <?php $n = 0; foreach (DIVISIONS as $d): foreach ($d['services'] as $key): $s = SERVICES[$key]; $n++; ?>
      <article class="svc reveal" id="<?= e($key) ?>">
        <div class="svc__num"><?= sprintf('%02d', $n) ?></div>
        <div>
          <span class="svc__tag"><?= e($d['title']) ?><?= !empty($s['by']) ? ' · by ANTS Design Ventures' : '' ?></span>
          <h2><?= e($s['title']) ?></h2>
          <p><?= e($s['text']) ?></p>
          <p style="margin-top:28px">
            <?php if (!empty($s['by'])): ?>
              <a class="link-arrow" href="<?= url('ants/') ?>">Visit ANTS Design Ventures <?= icon('arrow') ?></a>
            <?php else: ?>
              <a class="link-arrow" href="<?= url('contact.php?service=' . $key) ?>">Enquire about this service <?= icon('arrow') ?></a>
            <?php endif; ?>
          </p>
        </div>
        <ul>
          <?php foreach ($s['items'] as $it): ?><li><?= e($it) ?></li><?php endforeach; ?>
        </ul>
      </article>
    <?php endforeach; endforeach; ?>
  </div>
</section>

<section class="section section--alt">
  <div class="container">
    <div class="cta reveal">
      <div>
        <h2>Not sure where to start?</h2>
        <p>Tell us about your project and we&rsquo;ll recommend the right combination of services.</p>
      </div>
      <a class="btn btn--accent" href="<?= url('contact.php') ?>">Talk to our team <?= icon('arrow') ?></a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
