<?php
require_once __DIR__ . '/includes/bootstrap.php';
http_response_code(404);

$page = [
    'title'  => 'Page not found | ASTAN International',
    'desc'   => 'The page you are looking for could not be found.',
    'brand'  => 'astan',
    'active' => '',
    'path'   => '404.php',
];
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero page-hero--dark" style="min-height:60vh;display:flex;align-items:center">
  <div class="container">
    <span class="eyebrow">Error 404</span>
    <h1>This page <em>doesn&rsquo;t exist.</em></h1>
    <p class="lead">It may have moved, or the link may be incorrect.</p>
    <p style="margin-top:36px"><a class="btn btn--accent" href="<?= url() ?>">Back to home <?= icon('arrow') ?></a></p>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
