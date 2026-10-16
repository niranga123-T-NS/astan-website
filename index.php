<?php
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'  => 'ASTAN International (Pvt) Ltd | Engineering, Interiors, Property & Trade, Sri Lanka',
    'desc'   => 'ASTAN International (Pvt) Ltd, Thalawathugoda, Sri Lanka: MEP contracts, electrical consultancy, interior design (ANTS Design Ventures) and construction, real estate, import and export, and investments.',
    'brand'  => 'astan',
    'active' => 'home',
    'path'   => '',
    'class'  => 'page-home',
];

$featured = projects_featured(null, 3);
$heroProject = null;
// Banner photo: a real (non-sample) featured project, ASTAN's own first, otherwise ANTS.
foreach (array_merge(projects_featured('astan', 10), projects_featured('ants', 10)) as $p) {
    if (project_cover($p) && empty($p['sample'])) { $heroProject = $p; break; }
}
$heroImg  = $heroProject ? project_cover($heroProject) : null;
$aboutImg = $heroProject ? ($heroProject['images'][5] ?? $heroProject['images'][1] ?? null) : null;
$serviceCount = count(SERVICES);

require __DIR__ . '/includes/header.php';
?>

<section class="hero<?= $heroImg ? ' hero--photo' : '' ?>">
  <?php if ($heroImg): ?>
    <img class="hero__bg" src="<?= e(img_url($heroImg)) ?>" alt="" fetchpriority="high">
  <?php else: ?>
    <img class="hero__art" src="<?= url('assets/img/hero-building.svg') ?>" alt="" width="800" height="720">
  <?php endif; ?>
  <div class="container hero__inner">
    <div class="hero__content">
      <span class="eyebrow reveal">ASTAN International (Pvt) Ltd</span>
      <h1 class="reveal reveal-d1">Engineering, interiors and enterprise <span class="hl">you can rely on.</span></h1>
      <p class="hero__lead reveal reveal-d2">One accountable partner for MEP contracting, electrical consultancy, interior design and construction, real estate, international trade and investment.</p>
      <div class="hero__actions reveal reveal-d3">
        <a class="btn btn--accent" href="<?= url('contact.php') ?>">Request a quote <?= icon('arrow') ?></a>
        <a class="btn btn--ghost" href="<?= url('portfolio.php') ?>">View our projects</a>
      </div>
    </div>
    <?php if ($heroProject): ?>
      <a class="hero__tag reveal reveal-d3" href="<?= url('project.php?p=' . rawurlencode($heroProject['slug'])) ?>">
        <span>Featured project</span>
        <strong><?= e($heroProject['title']) ?></strong>
        <em><?= e($heroProject['year'] ?? '') ?> &middot; <?= e(brand_label($heroProject['brand'])) ?> <?= icon('arrow') ?></em>
      </a>
    <?php endif; ?>
  </div>
  <div class="container">
    <dl class="kpis reveal">
      <div><dt><?= count(DIVISIONS) ?></dt><dd>Business divisions</dd></div>
      <div><dt><?= $serviceCount ?></dt><dd>Specialist services</dd></div>
      <div><dt>2</dt><dd>Group companies</dd></div>
      <div><dt>1</dt><dd>Accountable partner</dd></div>
    </dl>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow">What we do</span>
      <h2>Four divisions. One coordinated team.</h2>
      <p class="lead">Choose a single service or combine several. Our divisions plan and deliver together, so your project runs smoothly from start to finish.</p>
    </div>
    <div class="divisions">
      <?php foreach (DIVISIONS as $key => $d): ?>
        <article class="division reveal<?= $key === 'interiors' ? ' division--ants' : '' ?>">
          <span class="division__icon"><?= icon($d['icon']) ?></span>
          <h3><?= e($d['title']) ?></h3>
          <?php if ($key === 'interiors'): ?><span class="division__tag">with ANTS Design Ventures</span><?php endif; ?>
          <p><?= e($d['intro']) ?></p>
          <ul>
            <?php foreach ($d['services'] as $s): ?><li><?= icon('check') ?><?= e(SERVICES[$s]['title']) ?></li><?php endforeach; ?>
          </ul>
          <a class="link-arrow" href="<?= url('services.php#' . $d['services'][0]) ?>">Learn more <?= icon('arrow') ?></a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--alt">
  <div class="container split">
    <div class="split__media reveal">
      <?php if ($aboutImg): ?>
        <img src="<?= e(img_url($aboutImg)) ?>" alt="<?= e($heroProject['title']) ?>" loading="lazy">
      <?php else: ?>
        <div class="art-dark"><img src="<?= url('assets/img/hero-building.svg') ?>" alt="" width="800" height="720"></div>
      <?php endif; ?>
      <div class="split__badge">
        <img src="<?= url('assets/img/ants-logo.svg') ?>" alt="">
        <div><strong>ANTS Design Ventures</strong>Our in-house design arm</div>
      </div>
    </div>
    <div class="reveal reveal-d1">
      <span class="eyebrow">About the group</span>
      <h2>From first idea to final handover, under one roof.</h2>
      <p class="lead">ASTAN International (Pvt) Ltd is a registered Sri Lankan company based in Thalawathugoda. With our design arm, ANTS Design Ventures, we serve homeowners, businesses, developers and international partners.</p>
      <ul class="checklist">
        <li><?= icon('check') ?>Design, engineering and construction coordinated by one team</li>
        <li><?= icon('check') ?>Transparent quotations and regular progress updates</li>
        <li><?= icon('check') ?>Local delivery with international trade and partner networks</li>
      </ul>
      <div class="facts">
        <div class="fact"><strong>Company Reg.</strong><span><?= e(COMPANIES['astan']['reg']) ?></span></div>
        <div class="fact"><strong>Headquarters</strong><span>Thalawathugoda</span></div>
      </div>
      <a class="btn btn--dark" href="<?= url('about.php') ?>">About the group <?= icon('arrow') ?></a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head section-head--row reveal">
      <div>
        <span class="eyebrow">Our work</span>
        <h2>Featured projects</h2>
      </div>
      <a class="btn btn--line" href="<?= url('portfolio.php') ?>">View full portfolio <?= icon('arrow') ?></a>
    </div>
    <?php if ($featured): ?>
      <div class="work-grid">
        <?php foreach ($featured as $p): ?><div class="reveal"><?= project_card($p) ?></div><?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="empty-state">Our portfolio is being updated. New projects will appear here soon.</div>
    <?php endif; ?>
  </div>
</section>

<section class="section section--dark">
  <div class="container">
    <div class="section-head section-head--center reveal">
      <span class="eyebrow">Why ASTAN</span>
      <h2>Why clients choose us</h2>
    </div>
    <div class="values">
      <div class="value reveal"><span class="value__icon"><?= icon('id') ?></span><h3>Integrity</h3><p>Honest advice, fair pricing and clear contracts.</p></div>
      <div class="value reveal reveal-d1"><span class="value__icon"><?= icon('build') ?></span><h3>Quality</h3><p>Proper materials, skilled workmanship and close supervision.</p></div>
      <div class="value reveal reveal-d2"><span class="value__icon"><?= icon('check') ?></span><h3>Reliability</h3><p>Careful planning, regular updates and on-time delivery.</p></div>
      <div class="value reveal reveal-d3"><span class="value__icon"><?= icon('trade') ?></span><h3>Reach</h3><p>Rooted in Sri Lanka, with partners and supply chains abroad.</p></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head section-head--center reveal">
      <span class="eyebrow">How we work</span>
      <h2>A clear four-step process</h2>
      <p class="lead">Transparent from the first meeting to the final handover.</p>
    </div>
    <ol class="process">
      <li class="reveal"><h3>Consult</h3><p>We listen to your goals, visit the site and understand your budget and timeline.</p></li>
      <li class="reveal reveal-d1"><h3>Plan &amp; design</h3><p>Drawings, specifications and a transparent quotation for your approval.</p></li>
      <li class="reveal reveal-d2"><h3>Deliver</h3><p>Skilled teams carry out the work with close supervision and quality checks.</p></li>
      <li class="reveal reveal-d3"><h3>Hand over</h3><p>Testing, handover and support long after the project is complete.</p></li>
    </ol>
  </div>
</section>

<section class="section ants-band">
  <div class="container ants-band__grid">
    <div class="reveal">
      <img class="ants-band__logo" src="<?= url('assets/img/ants-logo.svg') ?>" alt="ANTS Design Ventures">
      <span class="eyebrow">Our design arm</span>
      <h2>ANTS Design Ventures</h2>
      <p class="lead">The interior design studio of ASTAN International. ANTS designs considered, beautiful spaces for homes, workplaces and hospitality, and our construction team builds them.</p>
      <a class="btn btn--dark" href="<?= url('ants/') ?>">Visit ANTS Design <?= icon('arrow') ?></a>
    </div>
    <div class="ants-band__visual reveal reveal-d1">
      <img src="<?= url('assets/img/interior-line.svg') ?>" alt="" width="800" height="640">
    </div>
  </div>
</section>

<section class="cta-band">
  <div class="container cta">
    <div>
      <h2>Have a project in mind?</h2>
      <p>Tell us what you need and we&rsquo;ll come back with advice and a clear quotation.</p>
    </div>
    <div class="cta__actions">
      <a class="btn btn--accent" href="<?= url('contact.php') ?>">Request a quote <?= icon('arrow') ?></a>
      <a class="btn btn--ghost" href="<?= tel(PHONES[0]) ?>"><?= icon('phone') ?><?= e(PHONES[0]) ?></a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
