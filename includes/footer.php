<?php
defined('APP') or exit;
$brand = $page['brand'] ?? 'astan';
$a = COMPANIES['astan'];
$n = COMPANIES['ants'];
?>
  </main>

  <footer class="site-footer">
    <div class="container">
      <div class="footer-top">
        <p class="footer-statement"><?= $brand === 'ants'
            ? 'Thoughtful interiors and spaces, <em>designed to be lived in.</em>'
            : 'Engineering, interiors and enterprise &mdash; <em>delivered with integrity.</em>' ?></p>
        <a class="btn btn--light" href="<?= url($brand === 'ants' ? 'ants/#contact' : 'contact.php') ?>">Start a conversation <?= icon('arrow') ?></a>
      </div>

      <div class="footer-grid">
        <div class="footer-co">
          <a class="brand brand--footer" href="<?= url() ?>">
            <img src="<?= url($a['logo']) ?>" alt="" width="40" height="40">
            <span class="brand__text"><span class="brand__name">ASTAN</span><span class="brand__sub">International (Pvt) Ltd</span></span>
          </a>
          <p>MEP contracts, electrical consultancy, interior construction, real estate, international trade and investments.</p>
          <p class="muted">Reg. No. <?= e($a['reg']) ?> &middot; <a href="mailto:<?= e($a['email']) ?>"><?= e($a['email']) ?></a></p>
        </div>
        <div class="footer-co">
          <a class="brand brand--footer brand--ants" href="<?= url('ants/') ?>">
            <img class="on-light" src="<?= url($n['logo']) ?>" alt="" width="48" height="40">
            <span class="brand__text"><span class="brand__name">ANTS</span><span class="brand__sub">Design Ventures</span></span>
          </a>
          <p>The design arm of ASTAN International &mdash; interior design, space planning and design-led projects.</p>
          <p class="muted">Reg. No. <?= e($n['reg']) ?> &middot; <a href="mailto:<?= e($n['email']) ?>"><?= e($n['email']) ?></a></p>
        </div>
        <div>
          <h4>Explore</h4>
          <ul>
            <li><a href="<?= url('about.php') ?>">About the group</a></li>
            <li><a href="<?= url('services.php') ?>">Services</a></li>
            <li><a href="<?= url('portfolio.php') ?>">Portfolio</a></li>
            <li><a href="<?= url('ants/') ?>">ANTS Design Ventures</a></li>
            <li><a href="<?= url('contact.php') ?>">Contact</a></li>
          </ul>
        </div>
        <div>
          <h4>Visit &amp; call</h4>
          <ul>
            <li><?= e(ADDRESS) ?></li>
            <?php foreach (PHONES as $ph): ?>
              <li><a href="<?= tel($ph) ?>"><?= e($ph) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <div class="footer-bottom">
        <span>&copy; <?= date('Y') ?> ASTAN International (Pvt) Ltd &amp; ANTS Design Ventures. All rights reserved.</span>
        <span>Thalawathugoda &middot; Sri Lanka</span>
      </div>
    </div>
  </footer>

  <a class="wa-float" href="https://wa.me/<?= e(WHATSAPP) ?>" target="_blank" rel="noopener" aria-label="Chat on WhatsApp"><?= icon('whatsapp') ?></a>
  <script src="<?= url('assets/js/site.js') ?>?v=2" defer></script>
</body>
</html>
