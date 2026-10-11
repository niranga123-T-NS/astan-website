<?php
// Shared admin helpers: login, throttling and page layout.
require __DIR__ . '/../includes/bootstrap.php';

const ADMIN_FILE    = DATA_DIR . '/admin.json';
const ATTEMPTS_FILE = DATA_DIR . '/login-attempts.json';
const MAX_ATTEMPTS  = 5;
const LOCK_MINUTES  = 15;
const IDLE_MINUTES  = 120;

header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');
header('Cache-Control: no-store');
start_session();

function admin_hash(): string
{
    if (is_file(ADMIN_FILE)) {
        $d = json_decode((string)file_get_contents(ADMIN_FILE), true);
        if (!empty($d['hash'])) {
            return $d['hash'];
        }
    }
    return ADMIN_PASSWORD_HASH;
}

function admin_set_password(string $pw): bool
{
    return file_put_contents(ADMIN_FILE, json_encode(['hash' => password_hash($pw, PASSWORD_DEFAULT), 'changed' => date('c')]), LOCK_EX) !== false;
}

function client_key(): string
{
    return hash('sha256', $_SERVER['REMOTE_ADDR'] ?? 'unknown');
}

function attempts_load(): array
{
    $d = is_file(ATTEMPTS_FILE) ? json_decode((string)file_get_contents(ATTEMPTS_FILE), true) : [];
    $d = is_array($d) ? $d : [];
    $cut = time() - LOCK_MINUTES * 60;
    return array_filter($d, fn($r) => ($r['t'] ?? 0) > $cut);
}

function login_locked(): bool
{
    $r = attempts_load()[client_key()] ?? null;
    return $r && $r['n'] >= MAX_ATTEMPTS;
}

function login_failed(): void
{
    $d = attempts_load();
    $k = client_key();
    $d[$k] = ['n' => ($d[$k]['n'] ?? 0) + 1, 't' => time()];
    file_put_contents(ATTEMPTS_FILE, json_encode($d), LOCK_EX);
}

function login_clear(): void
{
    $d = attempts_load();
    unset($d[client_key()]);
    file_put_contents(ATTEMPTS_FILE, json_encode($d), LOCK_EX);
}

function is_logged_in(): bool
{
    if (empty($_SESSION['admin'])) {
        return false;
    }
    if (time() - ($_SESSION['seen'] ?? 0) > IDLE_MINUTES * 60) {
        $_SESSION = [];
        return false;
    }
    $_SESSION['seen'] = time();
    return true;
}

function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: ' . url('admin/'));
        exit;
    }
}

function flash(?string $msg = null, string $type = 'ok')
{
    if ($msg !== null) {
        $_SESSION['flash'] = [$type, $msg];
        return null;
    }
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}

function redirect(string $path): void
{
    header('Location: ' . url($path), true, 303);
    exit;
}

function admin_head(string $title): void
{
    $f = flash();
    ?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <title><?= e($title) ?> · Website Admin</title>
  <link rel="icon" href="<?= url('assets/img/favicon.svg') ?>" type="image/svg+xml">
  <link rel="stylesheet" href="<?= url('admin/admin.css') ?>?v=2">
</head>
<body>
  <header class="top">
    <a class="top__brand" href="<?= url('admin/') ?>"><img src="<?= url('assets/img/logo-mark.svg') ?>" alt="" width="28"> Website Admin</a>
    <?php if (is_logged_in()): ?>
      <nav>
        <a href="<?= url('admin/') ?>">Projects</a>
        <a href="<?= url('admin/edit.php') ?>">+ New project</a>
        <a href="<?= url('admin/password.php') ?>">Password</a>
        <a href="<?= url() ?>" target="_blank" rel="noopener">View site ↗</a>
        <form method="post" action="<?= url('admin/logout.php') ?>"><?= csrf_field() ?><button>Log out</button></form>
      </nav>
    <?php endif; ?>
  </header>
  <main class="wrap">
    <?php if ($f): ?><div class="msg msg--<?= e($f[0]) ?>"><?= e($f[1]) ?></div><?php endif; ?>
<?php
}

function admin_foot(): void
{
    ?>
  </main>
  <script src="<?= url('admin/admin.js') ?>?v=2" defer></script>
</body>
</html>
<?php
}
