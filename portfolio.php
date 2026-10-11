<?php
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'  => 'Portfolio | ASTAN International & ANTS Design Ventures',
    'desc'   => 'Selected projects by ASTAN International (Pvt) Ltd and its design arm ANTS Design Ventures: MEP, electrical, interior design, interior construction and more.',
    'brand'  => 'astan',
    'active' => 'portfolio',
    'path'   => 'portfolio.php',
];
$projects = projects_published();
$showBrandFilter = true;
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="container">
    <div class="crumbs"><a href="<?= url() ?>">Home</a> &nbsp;/&nbsp; Portfolio</div>
    <span class="eyebrow">Portfolio</span>
    <h1>Our <em>work</em></h1>
    <p class="lead">Selected projects from ASTAN International and ANTS Design Ventures, our design arm. New projects are added regularly.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php require __DIR__ . '/includes/portfolio-grid.php'; ?>
  </div>
</section>

<section class="section section--alt">
  <div class="container">
    <div class="cta reveal">
      <div>
        <h2>Planning a similar project?</h2>
        <p>We&rsquo;d be glad to share more detail about our work and how we can help.</p>
      </div>
      <a class="btn btn--accent" href="<?= url('contact.php') ?>">Start a conversation <?= icon('arrow') ?></a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
