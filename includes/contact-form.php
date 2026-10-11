<?php
defined('APP') or exit;
/** Contact form. Expects $formBrand ('astan'|'ants') and $formOptions (list of service names). */
$status = $_GET['status'] ?? '';
$pre = is_string($_GET['service'] ?? null) && isset(SERVICES[$_GET['service']]) ? SERVICES[$_GET['service']]['title'] : '';
?>
<form class="form" method="post" action="#enquiry" id="enquiry">
  <?php if ($status === 'sent'): ?>
    <div class="notice notice--ok" role="status">Thank you! Your message has been sent. We&rsquo;ll be in touch shortly.</div>
  <?php elseif ($status === 'error'): ?>
    <div class="notice notice--err" role="alert">Sorry, your message could not be sent. Please check your details, or email us at <a href="mailto:<?= e(company($formBrand)['email']) ?>"><?= e(company($formBrand)['email']) ?></a>.</div>
  <?php endif; ?>
  <h3>Send us a message</h3>
  <input type="hidden" name="form" value="contact">
  <div class="form-row">
    <div class="field"><label for="f-name">Full name *</label><input id="f-name" name="name" required maxlength="100" autocomplete="name"></div>
    <div class="field"><label for="f-email">Email *</label><input id="f-email" name="email" type="email" required maxlength="150" autocomplete="email"></div>
  </div>
  <div class="form-row">
    <div class="field"><label for="f-phone">Phone</label><input id="f-phone" name="phone" type="tel" maxlength="30" autocomplete="tel"></div>
    <div class="field">
      <label for="f-service"><?= $formBrand === 'ants' ? 'Project type' : 'Service' ?></label>
      <select id="f-service" name="service">
        <option>General enquiry</option>
        <?php foreach ($formOptions as $o): ?><option<?= $o === $pre ? ' selected' : '' ?>><?= e($o) ?></option><?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="field"><label for="f-msg">Message *</label><textarea id="f-msg" name="message" required maxlength="5000" placeholder="<?= $formBrand === 'ants' ? 'Tell us about your space: type, size, location and timeline.' : 'Tell us about your project or requirement.' ?>"></textarea></div>
  <div class="hp" aria-hidden="true"><label for="f-web">Leave empty</label><input id="f-web" name="website" tabindex="-1" autocomplete="off"></div>
  <button class="btn btn--dark" type="submit">Send message <?= icon('arrow') ?></button>
</form>
