<?php
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'  => 'About the Group | ASTAN International (Pvt) Ltd',
    'desc'   => 'ASTAN International (Pvt) Ltd and its design arm ANTS Design Ventures: a Sri Lankan group delivering engineering, interiors, property, trade and investment services.',
    'brand'  => 'astan',
    'active' => 'about',
    'path'   => 'about.php',
];
$a = COMPANIES['astan'];
$n = COMPANIES['ants'];
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero page-hero--dark">
  <div class="container">
    <div class="crumbs"><a href="<?= url() ?>">Home</a> &nbsp;/&nbsp; About</div>
    <span class="eyebrow">About the group</span>
    <h1>A trusted partner for building, <em>design</em> &amp; trade</h1>
    <p class="lead">Two companies, one standard: ASTAN International (Pvt) Ltd and its design arm, ANTS Design Ventures.</p>
  </div>
</section>

<section class="section">
  <div class="container split">
    <div class="reveal">
      <span class="eyebrow">Our story</span>
      <h2>Fewer handovers. <em>Better</em> results.</h2>
      <p class="lead">ASTAN International (Pvt) Ltd is a registered Sri Lankan private limited company (Reg. No. <?= e($a['reg']) ?>) headquartered in Thalawathugoda.</p>
      <p>We started from a simple idea: clients should not have to manage a long list of separate contractors, consultants and suppliers to get a project done well. Bringing MEP engineering, electrical consultancy, interior design and construction, real estate, international trade and investment together makes projects simpler, faster and more reliable.</p>
      <p>Our design arm, ANTS Design Ventures, adds a dedicated creative studio to the group, so the same team that designs a space can also engineer and build it.</p>
    </div>
    <div class="frame reveal reveal-d1">
      <div class="art-dark"><img src="<?= url('assets/img/hero-building.svg') ?>" alt="" width="800" height="720"></div>
    </div>
  </div>
</section>

<section class="section section--alt">
  <div class="container">
    <div class="head-row reveal">
      <div>
        <span class="eyebrow">The group</span>
        <h2>Two companies, <em>one team</em></h2>
      </div>
    </div>
    <div class="group">
      <div class="group-card group-card--astan reveal">
        <img src="<?= url('assets/img/logo-original.png') ?>" alt="ASTAN International logo" style="background:#fff;padding:6px;border-radius:4px">
        <h3><?= e($a['name']) ?></h3>
        <p>Engineering &amp; MEP, interior construction, real estate, investments and international trade.</p>
        <dl>
          <dt>Reg. No.</dt><dd><?= e($a['reg']) ?></dd>
          <dt>Email</dt><dd><a href="mailto:<?= e($a['email']) ?>"><?= e($a['email']) ?></a></dd>
          <dt>Web</dt><dd><?= e($a['web']) ?></dd>
        </dl>
        <a class="link-arrow" href="<?= url('services.php') ?>">ASTAN services <?= icon('arrow') ?></a>
      </div>
      <div class="group-card group-card--ants reveal reveal-d1">
        <img src="<?= url('assets/img/ants-logo.svg') ?>" alt="ANTS Design Ventures logo">
        <h3><?= e($n['name']) ?></h3>
        <p>The design arm of ASTAN International: interior design, space planning, visualisation and design-led projects.</p>
        <dl>
          <dt>Reg. No.</dt><dd><?= e($n['reg']) ?></dd>
          <dt>Email</dt><dd><a href="mailto:<?= e($n['email']) ?>"><?= e($n['email']) ?></a></dd>
          <dt>Web</dt><dd><?= e($n['web']) ?></dd>
        </dl>
        <a class="link-arrow" href="<?= url('ants/') ?>">Visit ANTS Design <?= icon('arrow') ?></a>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="mv">
      <div class="reveal">
        <span class="eyebrow">Mission</span>
        <h3>Value that lasts</h3>
        <p>To deliver integrated engineering, design, property and trade solutions that create lasting value for our clients, through quality workmanship, transparent dealings and dependable service.</p>
      </div>
      <div class="reveal reveal-d1">
        <span class="eyebrow">Vision</span>
        <h3>Recognised for excellence</h3>
        <p>To be a leading Sri Lankan group, recognised at home and abroad for excellence in building services, interiors, real estate and international trade.</p>
      </div>
    </div>
  </div>
</section>

<section class="section section--dark">
  <div class="container">
    <div class="head-row reveal">
      <div>
        <span class="eyebrow">Our values</span>
        <h2>What we <em>stand for</em></h2>
      </div>
    </div>
    <div class="values">
      <div class="value reveal"><?= icon('id') ?><h3>Integrity</h3><p>Honest advice, fair pricing and clear contracts.</p></div>
      <div class="value reveal reveal-d1"><?= icon('build') ?><h3>Quality</h3><p>High standards of materials, workmanship and safety.</p></div>
      <div class="value reveal reveal-d2"><?= icon('check') ?><h3>Reliability</h3><p>Careful planning and delivering what we promise, on time.</p></div>
      <div class="value reveal reveal-d3"><?= icon('trade') ?><h3>Partnership</h3><p>Long-term relationships with clients, suppliers and investors.</p></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="cta reveal">
      <div>
        <h2>Let&rsquo;s build something together</h2>
        <p>Talk to us about your project, property or trade requirement.</p>
      </div>
      <a class="btn btn--accent" href="<?= url('contact.php') ?>">Contact us <?= icon('arrow') ?></a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
