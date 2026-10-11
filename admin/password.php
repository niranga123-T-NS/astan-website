<?php
require __DIR__ . '/_lib.php';
require_login();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cur = (string)($_POST['current'] ?? '');
    $new = (string)($_POST['new'] ?? '');
    if (!csrf_ok()) {
        $error = 'Your session expired. Please try again.';
    } elseif (!password_verify($cur, admin_hash())) {
        $error = 'Your current password is incorrect.';
    } elseif (strlen($new) < 10) {
        $error = 'Your new password must be at least 10 characters long.';
    } elseif ($new !== ($_POST['confirm'] ?? '')) {
        $error = 'The two new passwords do not match.';
    } elseif (!admin_set_password($new)) {
        $error = 'Could not save. Check that the "data" folder is writable on the server.';
    } else {
        session_regenerate_id(true);
        flash('Password changed.');
        redirect('admin/');
    }
}

admin_head('Change password');
?>
<form class="card narrow" method="post">
  <h1>Change password</h1>
  <?php if ($error): ?><div class="msg msg--err"><?= e($error) ?></div><?php endif; ?>
  <?= csrf_field() ?>
  <label class="field">Current password<input type="password" name="current" required autocomplete="current-password"></label>
  <label class="field">New password <small>(at least 10 characters)</small><input type="password" name="new" required minlength="10" autocomplete="new-password"></label>
  <label class="field">Repeat new password<input type="password" name="confirm" required minlength="10" autocomplete="new-password"></label>
  <button class="btn">Save new password</button>
</form>
<?php admin_foot(); ?>
