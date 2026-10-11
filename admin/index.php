<?php
require __DIR__ . '/_lib.php';

// ---- Login ----
if (!is_logged_in()) {
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!csrf_ok()) {
            $error = 'Your session expired. Please try again.';
        } elseif (login_locked()) {
            $error = 'Too many failed attempts. Please wait ' . LOCK_MINUTES . ' minutes and try again.';
        } elseif (password_verify((string)($_POST['password'] ?? ''), admin_hash())) {
            login_clear();
            session_regenerate_id(true);
            $_SESSION['admin'] = true;
            $_SESSION['seen'] = time();
            redirect('admin/');
        } else {
            login_failed();
            usleep(600000);
            $error = 'Incorrect password.';
        }
    }
    admin_head('Log in');
    ?>
    <form class="card login" method="post">
      <h1>Website admin</h1>
      <p class="hint">ASTAN International &amp; ANTS Design Ventures</p>
      <?php if ($error): ?><div class="msg msg--err"><?= e($error) ?></div><?php endif; ?>
      <?= csrf_field() ?>
      <label>Password<input type="password" name="password" required autofocus autocomplete="current-password"></label>
      <button class="btn">Log in</button>
    </form>
    <?php
    admin_foot();
    exit;
}

// ---- Quick actions (publish / feature / delete) ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_ok()) {
        flash('Your session expired. Please try again.', 'err');
        redirect('admin/');
    }
    $id = (string)($_POST['id'] ?? '');
    $action = (string)($_POST['action'] ?? '');
    $list = projects_all();
    foreach ($list as $i => $p) {
        if ($p['id'] !== $id) {
            continue;
        }
        if ($action === 'delete') {
            foreach ($p['images'] ?? [] as $img) {
                delete_image($img);
            }
            unset($list[$i]);
            flash('Deleted "' . $p['title'] . '".');
        } elseif ($action === 'publish') {
            $list[$i]['published'] = empty($p['published']);
            flash(($list[$i]['published'] ? 'Published' : 'Hidden') . ': "' . $p['title'] . '".');
        } elseif ($action === 'feature') {
            $list[$i]['featured'] = empty($p['featured']);
            flash(($list[$i]['featured'] ? 'Featured' : 'No longer featured') . ': "' . $p['title'] . '".');
        }
        projects_save($list);
        break;
    }
    redirect('admin/' . (isset($_POST['brand']) && in_array($_POST['brand'], ['astan', 'ants'], true) ? '?brand=' . $_POST['brand'] : ''));
}

// ---- Project list ----
$brand = in_array($_GET['brand'] ?? '', ['astan', 'ants'], true) ? $_GET['brand'] : '';
$list = array_values(array_filter(projects_all(), fn($p) => $brand === '' || $p['brand'] === $brand));
$count = ['astan' => 0, 'ants' => 0];
foreach (projects_all() as $p) {
    $count[$p['brand']]++;
}

admin_head('Projects');
?>
<div class="bar">
  <h1>Portfolio projects</h1>
  <a class="btn" href="<?= url('admin/edit.php' . ($brand ? '?brand=' . $brand : '')) ?>">+ Add project</a>
</div>
<div class="tabs">
  <a href="<?= url('admin/') ?>" class="<?= $brand === '' ? 'on' : '' ?>">All (<?= $count['astan'] + $count['ants'] ?>)</a>
  <a href="<?= url('admin/?brand=astan') ?>" class="<?= $brand === 'astan' ? 'on' : '' ?>">ASTAN International (<?= $count['astan'] ?>)</a>
  <a href="<?= url('admin/?brand=ants') ?>" class="<?= $brand === 'ants' ? 'on' : '' ?>">ANTS Design (<?= $count['ants'] ?>)</a>
</div>

<?php if (!$list): ?>
  <div class="card empty">
    <p>No projects yet.</p>
    <a class="btn" href="<?= url('admin/edit.php' . ($brand ? '?brand=' . $brand : '')) ?>">Add your first project</a>
  </div>
<?php else: ?>
  <div class="plist">
    <?php foreach ($list as $p): $c = project_cover($p); ?>
      <div class="pitem<?= empty($p['published']) ? ' is-draft' : '' ?>">
        <a class="pitem__img" href="<?= url('admin/edit.php?id=' . rawurlencode($p['id'])) ?>">
          <?php if ($c): ?><img src="<?= e(img_url($c, 'thumb')) ?>" alt=""><?php else: ?><span>No photo</span><?php endif; ?>
        </a>
        <div class="pitem__body">
          <div class="tags">
            <span class="tag tag--<?= e($p['brand']) ?>"><?= e(brand_label($p['brand'])) ?></span>
            <?php if (empty($p['published'])): ?><span class="tag tag--draft">Hidden</span><?php endif; ?>
            <?php if (!empty($p['featured'])): ?><span class="tag tag--star">★ Featured</span><?php endif; ?>
            <?php if (!empty($p['sample'])): ?><span class="tag tag--sample">Sample, delete when ready</span><?php endif; ?>
          </div>
          <h3><a href="<?= url('admin/edit.php?id=' . rawurlencode($p['id'])) ?>"><?= e($p['title']) ?></a></h3>
          <p class="hint"><?= e(implode(' · ', array_filter([$p['category'] ?? '', $p['location'] ?? '', $p['year'] ?? '', count($p['images'] ?? []) . ' photo(s)']))) ?></p>
          <div class="actions">
            <a class="btn btn--sm" href="<?= url('admin/edit.php?id=' . rawurlencode($p['id'])) ?>">Edit</a>
            <?php if (!empty($p['published'])): ?><a class="btn btn--sm btn--ghost" href="<?= url('project.php?p=' . rawurlencode($p['slug'])) ?>" target="_blank" rel="noopener">View ↗</a><?php endif; ?>
            <?php foreach (['publish' => empty($p['published']) ? 'Publish' : 'Hide', 'feature' => empty($p['featured']) ? '★ Feature' : 'Unfeature'] as $act => $label): ?>
              <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= e($p['id']) ?>"><input type="hidden" name="brand" value="<?= e($brand) ?>"><button class="btn btn--sm btn--ghost" name="action" value="<?= $act ?>"><?= $label ?></button></form>
            <?php endforeach; ?>
            <form method="post" data-confirm="Delete &quot;<?= e($p['title']) ?>&quot; and all its photos? This cannot be undone."><?= csrf_field() ?><input type="hidden" name="id" value="<?= e($p['id']) ?>"><input type="hidden" name="brand" value="<?= e($brand) ?>"><button class="btn btn--sm btn--danger" name="action" value="delete">Delete</button></form>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
<?php admin_foot(); ?>
