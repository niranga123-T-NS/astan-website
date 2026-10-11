<?php
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'  => 'ASTAN International (Pvt) Ltd | Engineering, Interiors, Property & Trade, Sri Lanka',
    'desc'   => 'ASTAN International (Pvt) Ltd, Thalawathugoda, Sri Lanka: MEP contracts, electrical consultancy, interior design (ANTS Design Ventures) and construction, real estate, import and export, and investments.',
    'brand'  => 'astan',
    'active' => 'home',
    'path'   => '',
];

$featured = projects_featured(null, 3);
$heroProject = null;
// Banner photo: a real (non-sample) featured project, ASTAN's own first, otherwise ANTS.
foreach (array_merge(projects_featured('astan', 10), projects_featured('ants', 10)) as $p) {
    if (project_cover($p) && empty($p['sample'])) { $heroProject = $p; break; }
}

require __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="container hero__grid">
    <div>
      <span class="eyebrow reveal">ASTAN International (Pvt) Ltd &middot; Sri Lanka</span>
      <h1 class="reveal reveal-d1">Engineering, interiors &amp; enterprise, <em>built on trust.</em></h1>
      <p class="hero__lead reveal reveal-d2">One partner for MEP contracting, electrical consultancy, interior design and construction, real estate, international trade and investment.</p>
      <div class="hero__actions reveal reveal-d3">
        <a class="btn btn--accent" href="<?= url('portfolio.php') ?>">View our work <?= icon('arrow') ?></a>
        <a class="btn btn--ghost" href="<?= url('services.php') ?>">Our services</a>
      </div>
    </div>
    <div class="hero__visual reveal reveal-d2">
      <?php if ($heroProject): $c = project_cover($heroProject); ?>
        <figure class="hero__photo">
          <img src="<?= e(img_url($c)) ?>" alt="<?= e($heroProject['title']) ?>">
          <figcaption><strong><?= e($heroProject['title']) ?></strong><?= e(implode(' · ', array_filter([$heroProject['location'] ?? '', $heroProject['year'] ?? '']))) ?></figcaption>
        </figure>
      <?php else: ?>
        <img src="<?= url('assets/img/hero-building.svg') ?>" alt="" width="800" height="720">
      <?php endif; ?>
    </div>
  </div>
</section>

<div class="container">
  <div class="pillars reveal">
    <?php $n = 0; foreach (DIVISIONS as $key => $d): $n++; ?>
      <a class="pillar" href="<?= url('services.php#' . $d['services'][0]) ?>">
        <span class="pillar__num">0<?= $n ?></span>
        <h3><?= e($d['title']) ?></h3>
        <p><?= e(implode(' · ', array_map(fn($s) => SERVICES[$s]['title'], $d['services']))) ?></p>
      </a>
    <?php endforeach; ?>
  </div>
</div>

<section class="section">
  <div class="container intro">
    <div class="reveal">
      <span class="eyebrow">Who we are</span>
      <h2>One group. <em>Every stage</em> of your project.</h2>
    </div>
    <div class="reveal reveal-d1">
      <p class="statement">We bring engineering, design, construction, property and trade under one roof, so you have a single accountable partner from first idea to final handover.</p>
      <p class="lead">ASTAN International (Pvt) Ltd is a Sri Lankan company based in Thalawathugoda. Together with our design arm, ANTS Design Ventures, we serve homeowners, businesses, developers and international partners who value honest advice, quality workmanship and on-time delivery.</p>
      <div class="facts">
        <div class="fact"><strong>Headquarters</strong><span>Thalawathugoda, Sri Lanka</span></div>
        <div class="fact"><strong>Company Reg.</strong><span><?= e(COMPANIES['astan']['reg']) ?></span></div>
        <div class="fact"><strong>Design arm</strong><span>ANTS Design Ventures</span></div>
        <div class="fact"><strong>Reach</strong><span>Local delivery, international trade</span></div>
      </div>
      <p style="margin-top:36px"><a class="link-arrow" href="<?= url('about.php') ?>">More about the group <?= icon('arrow') ?></a></p>
    </div>
  </div>
</section>

<div class="ticker" aria-hidden="true">
  <div class="ticker__track">
    <?php for ($k = 0; $k < 2; $k++): ?>
      <span>MEP Contracts</span><span>Electrical Consultancy</span><span>Interior Design</span><span>Interior Construction</span><span>Real Estate</span><span>Investments</span><span>Import &amp; Export</span><span>Service Exports</span>
    <?php endfor; ?>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="head-row reveal">
      <div>
        <span class="eyebrow">What we do</span>
        <h2>Four divisions, <em>one team</em></h2>
      </div>
      <p class="lead">Choose a single service or combine several. Our divisions work together so your project runs smoothly.</p>
    </div>
    <div class="divisions">
      <?php $n = 0; foreach (DIVISIONS as $key => $d): $n++; ?>
        <article class="division reveal<?= $key === 'interiors' ? ' division--ants' : '' ?>">
          <span class="division__icon"><?= icon($d['icon']) ?></span>
          <span class="division__num">0<?= $n ?></span>
          <?php if ($key === 'interiors'): ?><span class="division__tag">with ANTS Design Ventures</span><?php endif; ?>
          <h3><?= e($d['title']) ?></h3>
          <p><?= e($d['intro']) ?></p>
          <ul>
            <?php foreach ($d['services'] as $s): ?><li><?= e(SERVICES[$s]['title']) ?></li><?php endforeach; ?>
          </ul>
          <a class="link-arrow" href="<?= url('services.php#' . $d['services'][0]) ?>">Explore <?= icon('arrow') ?></a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--alt">
  <div class="container">
    <div class="head-row reveal">
      <div>
        <span class="eyebrow">Selected work</span>
        <h2>Recent <em>projects</em></h2>
      </div>
      <a class="link-arrow" href="<?= url('portfolio.php') ?>">View full portfolio <?= icon('arrow') ?></a>
    </div>
    <?php if ($featured): ?>
      <div class="work-grid<?= count($featured) === 3 ? ' work-grid--feature' : '' ?>">
        <?php foreach ($featured as $p): ?><div class="reveal"><?= project_card($p) ?></div><?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="empty-state">Our portfolio is being updated. New projects will appear here soon.</div>
    <?php endif; ?>
  </div>
</section>

<section class="section ants-band">
  <div class="container ants-band__grid">
    <div class="reveal">
      <span class="eyebrow">Our design arm</span>
      <h2>ANTS Design Ventures, <em>where spaces take shape.</em></h2>
      <p class="lead">ANTS is the interior design and creative studio of ASTAN International. It creates considered, beautiful spaces for homes, workplaces and hospitality, and our construction team builds them to the last detail.</p>
      <p style="margin-top:32px"><a class="btn btn--dark" href="<?= url('ants/') ?>">Visit ANTS Design <?= icon('arrow') ?></a></p>
    </div>
    <div class="ants-band__visual reveal reveal-d1">
      <img src="<?= url('assets/img/interior-line.svg') ?>" alt="" width="800" height="640">
      <img class="ants-band__logo" src="<?= url('assets/img/ants-logo.svg') ?>" alt="ANTS Design Ventures">
    </div>
  </div>
</section>

<section class="section section--dark">
  <div class="container">
    <div class="head-row reveal">
      <div>
        <span class="eyebrow">How we work</span>
        <h2>A clear, <em>proven</em> process</h2>
      </div>
      <p class="lead">Transparent from the first meeting to the final handover, with no surprises along the way.</p>
    </div>
    <div class="process">
      <div class="reveal"><h3>Consult</h3><p>We listen to your goals, visit the site and understand your budget and timeline.</p></div>
      <div class="reveal reveal-d1"><h3>Plan &amp; design</h3><p>Drawings, specifications and a transparent quotation, ready for your approval.</p></div>
      <div class="reveal reveal-d2"><h3>Deliver</h3><p>Skilled teams execute the work under close supervision and quality checks.</p></div>
      <div class="reveal reveal-d3"><h3>Hand over &amp; support</h3><p>Testing, handover and support long after the project is complete.</p></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="cta reveal">
      <div>
        <h2>Have a project in mind?</h2>
        <p>Tell us what you need and we&rsquo;ll come back with advice and a clear quotation.</p>
      </div>
      <a class="btn btn--accent" href="<?= url('contact.php') ?>">Contact us <?= icon('arrow') ?></a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
