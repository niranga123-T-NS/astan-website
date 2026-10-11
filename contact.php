<?php
require __DIR__ . '/includes/bootstrap.php';

if (($result = handle_contact('astan')) !== null) {
    header('Location: ' . url('contact.php?status=' . $result . '#enquiry'), true, 303);
    exit;
}

$page = [
    'title'  => 'Contact | ASTAN International (Pvt) Ltd',
    'desc'   => 'Contact ASTAN International (Pvt) Ltd, 318/4D Sirinanda Jothikarama Road, Thalawathugoda. Phone +94 778 844 346 / +94 754 649 083, email info@astan-int.lk.',
    'brand'  => 'astan',
    'active' => 'contact',
    'path'   => 'contact.php',
];
$formBrand = 'astan';
$formOptions = array_column(SERVICES, 'title');
$a = COMPANIES['astan'];
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="container">
    <div class="crumbs"><a href="<?= url() ?>">Home</a> &nbsp;/&nbsp; Contact</div>
    <span class="eyebrow">Contact</span>
    <h1>Let&rsquo;s talk about <em>your project</em></h1>
    <p class="lead">Call, email or send a message. We usually reply within one business day.</p>
  </div>
</section>

<section class="section">
  <div class="container contact-grid">
    <div class="reveal">
      <span class="eyebrow">Get in touch</span>
      <h2>Visit or call us</h2>
      <ul class="contact-list">
        <li><?= icon('pin') ?><div><strong>Office</strong><?= e(ADDRESS) ?></div></li>
        <li><?= icon('phone') ?><div><strong>Phone</strong><?php foreach (PHONES as $i => $ph): ?><?= $i ? '<br>' : '' ?><a href="<?= tel($ph) ?>"><?= e($ph) ?></a><?php endforeach; ?></div></li>
        <li><?= icon('mail') ?><div><strong>Email</strong><a href="mailto:<?= e($a['email']) ?>"><?= e($a['email']) ?></a><br><span class="muted">Design enquiries: <a href="mailto:<?= e(COMPANIES['ants']['email']) ?>"><?= e(COMPANIES['ants']['email']) ?></a></span></div></li>
        <li><?= icon('id') ?><div><strong>Registration</strong>ASTAN International (Pvt) Ltd &middot; <?= e($a['reg']) ?><br>ANTS Design Ventures &middot; <?= e(COMPANIES['ants']['reg']) ?></div></li>
      </ul>
    </div>
    <div class="reveal reveal-d1">
      <?php require __DIR__ . '/includes/contact-form.php'; ?>
    </div>
  </div>
</section>

<iframe class="map" title="Map: ASTAN International, Thalawathugoda" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
  src="https://www.google.com/maps?q=Sirinanda+Jothikarama+Road,+Thalawathugoda,+Sri+Lanka&amp;output=embed"></iframe>

<?php require __DIR__ . '/includes/footer.php'; ?>
