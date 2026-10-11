<?php
require __DIR__ . '/../includes/bootstrap.php';

$page = [
    'title'  => 'Portfolio | ANTS Design Ventures',
    'desc'   => 'Interior design and design-led projects by ANTS Design Ventures, the design arm of ASTAN International (Pvt) Ltd.',
    'brand'  => 'ants',
    'active' => 'ants-portfolio',
    'path'   => 'ants/portfolio.php',
];
$projects = projects_published('ants');
$showBrandFilter = false;
require __DIR__ . '/../includes/header.php';
?>

<section class="page-hero">
  <div class="container">
    <div class="crumbs"><a href="<?= url('ants/') ?>">ANTS Design</a> &nbsp;/&nbsp; Portfolio</div>
    <div class="ants-dots" aria-hidden="true"><i></i><i></i><i></i><i></i></div>
    <h1>Our <em>portfolio</em></h1>
    <p class="lead">Interiors and design projects by ANTS Design Ventures. New work is added regularly.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php require __DIR__ . '/../includes/portfolio-grid.php'; ?>
  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
