<?php
require __DIR__ . '/../includes/bootstrap.php';

if (($result = handle_contact('ants')) !== null) {
    header('Location: ' . url('ants/?status=' . $result . '#enquiry'), true, 303);
    exit;
}

$n = COMPANIES['ants'];
$page = [
    'title'  => 'ANTS Design Ventures | Interior Design Studio, Sri Lanka',
    'desc'   => 'ANTS Design Ventures, the design arm of ASTAN International: interior design, space planning, 3D visualisation, furniture and joinery, and design-and-build in Sri Lanka.',
    'brand'  => 'ants',
    'active' => 'ants',
    'path'   => 'ants/',
];
$work = projects_featured('ants', 6);
$heroPhoto = null;
foreach ($work as $p) {
    if (project_cover($p) && empty($p['sample'])) { $heroPhoto = $p; break; }
}
$formBrand = 'ants';
$formOptions = array_merge(CATEGORIES['ants'], ['Design & Build']);
require __DIR__ . '/../includes/header.php';
?>

<section class="ants-hero">
  <div class="container ants-hero__grid">
    <div>
      <div class="ants-dots reveal" aria-hidden="true"><i></i><i></i><i></i><i></i></div>
      <span class="eyebrow reveal">ANTS Design Ventures &middot; Interior design studio</span>
      <h1 class="reveal reveal-d1">Spaces designed <em>around the way you live</em> and work.</h1>
      <p class="lead reveal reveal-d2">We design homes, workplaces and hospitality interiors that are calm, functional and full of character, and we see them through to the finished space.</p>
      <div class="hero__actions reveal reveal-d3">
        <a class="btn btn--dark" href="<?= url('ants/portfolio.php') ?>">See our portfolio <?= icon('arrow') ?></a>
        <a class="btn btn--line" href="#contact">Start a project</a>
      </div>
      <div class="ants-parent reveal reveal-d3">
        <img src="<?= url('assets/img/logo-mark.svg') ?>" alt="">
        <span>The design arm of <a href="<?= url() ?>">ASTAN International (Pvt) Ltd</a></span>
      </div>
    </div>
    <div class="ants-hero__visual reveal reveal-d2">
      <?php if ($heroPhoto): ?>
        <div class="art has-photo"><img class="photo" src="<?= e(img_url(project_cover($heroPhoto))) ?>" alt="<?= e($heroPhoto['title']) ?>"></div>
      <?php else: ?>
        <div class="art"><img src="<?= url('assets/img/interior-line.svg') ?>" alt="" width="800" height="640"></div>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="section section--alt" id="services">
  <div class="container">
    <div class="head-row reveal">
      <div>
        <span class="eyebrow">What we do</span>
        <h2>Design, from <em>first sketch</em> to final detail</h2>
      </div>
      <p class="lead">One studio for every stage of your interior, with ASTAN&rsquo;s engineering and construction teams to build it.</p>
    </div>
    <div class="disciplines">
      <?php foreach (ANTS_SERVICES as $i => [$ic, $t, $d]): ?>
        <div class="discipline reveal<?= $i % 3 ? ' reveal-d' . ($i % 3) : '' ?>"><?= icon($ic) ?><h3><?= e($t) ?></h3><p><?= e($d) ?></p></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="head-row reveal">
      <div>
        <span class="eyebrow">Portfolio</span>
        <h2>Selected <em>projects</em></h2>
      </div>
      <a class="link-arrow" href="<?= url('ants/portfolio.php') ?>">View all projects <?= icon('arrow') ?></a>
    </div>
    <?php if ($work): ?>
      <div class="work-grid">
        <?php foreach ($work as $p): ?><div class="reveal"><?= project_card($p, false) ?></div><?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="empty-state">New projects are on their way. Check back soon.</div>
    <?php endif; ?>
  </div>
</section>

<section class="section section--dark">
  <div class="container">
    <div class="head-row reveal">
      <div>
        <span class="eyebrow">Sectors</span>
        <h2>Spaces we <em>design</em></h2>
      </div>
    </div>
    <div class="sectors reveal">
      <span>Homes &amp; apartments</span><span>Offices &amp; workplaces</span><span>Hotels &amp; hospitality</span><span>Retail &amp; showrooms</span><span>Restaurants &amp; caf&eacute;s</span><span>Clinics &amp; studios</span>
    </div>
  </div>
</section>

<section class="section" id="process">
  <div class="container">
    <div class="head-row reveal">
      <div>
        <span class="eyebrow">Process</span>
        <h2>How we <em>work together</em></h2>
      </div>
      <p class="lead">A calm, collaborative process with clear decisions at every step.</p>
    </div>
    <div class="process">
      <div class="reveal"><h3>Discover</h3><p>We meet, visit the space and understand how you want it to look, feel and work, and what you want to spend.</p></div>
      <div class="reveal reveal-d1"><h3>Concept</h3><p>Mood boards, layouts and 3D visuals bring the idea to life before anything is built.</p></div>
      <div class="reveal reveal-d2"><h3>Detail</h3><p>Drawings, materials, lighting and furniture are finalised, with a clear cost plan.</p></div>
      <div class="reveal reveal-d3"><h3>Deliver</h3><p>We oversee the build with ASTAN&rsquo;s teams through to styling and handover.</p></div>
    </div>
  </div>
</section>

<section class="section section--alt" id="contact">
  <div class="container contact-grid">
    <div class="reveal">
      <span class="eyebrow">Contact</span>
      <h2>Tell us about <em>your space</em></h2>
      <p class="lead">Share a few details and we&rsquo;ll arrange a consultation.</p>
      <ul class="contact-list">
        <li><?= icon('mail') ?><div><strong>Email</strong><a href="mailto:<?= e($n['email']) ?>"><?= e($n['email']) ?></a></div></li>
        <li><?= icon('phone') ?><div><strong>Phone</strong><?php foreach (PHONES as $i => $ph): ?><?= $i ? '<br>' : '' ?><a href="<?= tel($ph) ?>"><?= e($ph) ?></a><?php endforeach; ?></div></li>
        <li><?= icon('pin') ?><div><strong>Studio</strong><?= e(ADDRESS) ?></div></li>
        <li><?= icon('id') ?><div><strong>Registration</strong>ANTS Design Ventures &middot; <?= e($n['reg']) ?></div></li>
      </ul>
    </div>
    <div class="reveal reveal-d1">
      <?php require __DIR__ . '/../includes/contact-form.php'; ?>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
