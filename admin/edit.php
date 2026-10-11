<?php
require __DIR__ . '/_lib.php';
require_login();

$id = is_string($_GET['id'] ?? null) ? $_GET['id'] : '';
$p = $id !== '' ? project_find($id, 'id') : null;
if ($id !== '' && !$p) {
    flash('That project no longer exists.', 'err');
    redirect('admin/');
}
$isNew = !$p;
$p = $p ?: [
    'id' => '', 'slug' => '', 'brand' => in_array($_GET['brand'] ?? '', ['astan', 'ants'], true) ? $_GET['brand'] : 'ants',
    'title' => '', 'category' => '', 'location' => '', 'year' => date('Y'), 'client' => '',
    'summary' => '', 'description' => '', 'images' => [], 'featured' => false, 'published' => true,
];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST) && (int)($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
        $errors[] = 'The photos were too large to upload in one go. Please upload fewer photos at a time.';
    } elseif (!csrf_ok()) {
        $errors[] = 'Your session expired. Please log in again and retry.';
    } else {
        $in = fn($k, $max) => clean_line($_POST[$k] ?? '', $max);
        $p['brand']       = in_array($_POST['brand'] ?? '', ['astan', 'ants'], true) ? $_POST['brand'] : 'astan';
        $p['title']       = $in('title', 120);
        $p['category']    = $in('category', 60);
        $p['location']    = $in('location', 80);
        $p['year']        = $in('year', 12);
        $p['client']      = $in('client', 100);
        $p['summary']     = $in('summary', 300);
        $p['description'] = mb_substr(trim(strip_tags((string)($_POST['description'] ?? ''))), 0, 8000);
        $p['published']   = !empty($_POST['published']);
        $p['featured']    = !empty($_POST['featured']);

        if ($p['title'] === '') {
            $errors[] = 'Please enter a project title.';
        }

        // Existing photos: keep order, drop removed ones.
        $remove = array_map('strval', (array)($_POST['remove'] ?? []));
        $kept = $dropped = [];
        foreach ($p['images'] as $img) {
            if (in_array($img['src'], $remove, true)) {
                $dropped[] = $img;
            } else {
                $kept[] = $img;
            }
        }

        // New uploads.
        $added = [];
        $files = $_FILES['photos'] ?? null;
        if ($files && is_array($files['name'])) {
            foreach ($files['name'] as $i => $name) {
                if ($files['error'][$i] === UPLOAD_ERR_NO_FILE) {
                    continue;
                }
                $r = store_upload(['name' => $name, 'tmp_name' => $files['tmp_name'][$i], 'error' => $files['error'][$i], 'size' => $files['size'][$i]]);
                if (is_array($r)) {
                    $added[] = $r;
                } else {
                    $errors[] = $r;
                }
            }
        }

        if ($p['title'] === '') {
            foreach ($added as $img) {
                delete_image($img);
            }
        } else {
            $images = array_merge($kept, $added);
            // Chosen cover goes first.
            $cover = (string)($_POST['cover'] ?? '');
            foreach ($images as $i => $img) {
                if ($img['src'] === $cover) {
                    array_unshift($images, ...array_splice($images, $i, 1));
                    break;
                }
            }
            $p['images'] = $images;
            foreach ($dropped as $img) {
                delete_image($img);
            }

            $p['updated'] = time();
            $list = projects_all();
            if ($isNew) {
                $p['id'] = bin2hex(random_bytes(6));
                $p['slug'] = unique_slug($p['title']);
                $p['created'] = time();
                $list[] = $p;
            } else {
                unset($p['sample']);
                foreach ($list as $i => $row) {
                    if ($row['id'] === $p['id']) {
                        $list[$i] = $p;
                    }
                }
            }
            if (projects_save($list)) {
                $msg = ($isNew ? 'Project added' : 'Changes saved') . ($added ? ' with ' . count($added) . ' new photo(s)' : '') . '.';
                if ($errors) {
                    $msg .= ' Some photos were skipped: ' . implode(' ', $errors);
                }
                flash($msg, $errors ? 'warn' : 'ok');
                redirect('admin/edit.php?id=' . rawurlencode($p['id']));
            }
            $errors[] = 'Could not save. Check that the "data" folder is writable on the server.';
        }
    }
}

$cats = CATEGORIES[$p['brand']] ?? [];
$allCats = array_unique(array_merge(CATEGORIES['astan'], CATEGORIES['ants']));
admin_head($isNew ? 'New project' : 'Edit project');
?>
<div class="bar">
  <h1><?= $isNew ? 'New project' : 'Edit project' ?></h1>
  <div>
    <?php if (!$isNew && !empty($p['published'])): ?><a class="btn btn--ghost" href="<?= url('project.php?p=' . rawurlencode($p['slug'])) ?>" target="_blank" rel="noopener">View on site ↗</a><?php endif; ?>
    <a class="btn btn--ghost" href="<?= url('admin/') ?>">← All projects</a>
  </div>
</div>

<?php foreach ($errors as $err): ?><div class="msg msg--err"><?= e($err) ?></div><?php endforeach; ?>

<form class="edit" method="post" enctype="multipart/form-data" data-resize>
  <?= csrf_field() ?>
  <div class="card">
    <h2>Details</h2>
    <div class="field">
      <span class="label">Show this project under</span>
      <div class="seg">
        <label><input type="radio" name="brand" value="ants" <?= $p['brand'] === 'ants' ? 'checked' : '' ?>> <span>ANTS Design Ventures<small>Interior design &amp; design projects</small></span></label>
        <label><input type="radio" name="brand" value="astan" <?= $p['brand'] === 'astan' ? 'checked' : '' ?>> <span>ASTAN International<small>MEP, electrical, construction, property, trade</small></span></label>
      </div>
    </div>
    <label class="field">Project title *<input name="title" value="<?= e($p['title']) ?>" required maxlength="120" placeholder="e.g. Apartment interior, Colombo 7"></label>
    <div class="row">
      <label class="field">Category<input name="category" value="<?= e($p['category']) ?>" list="cats" maxlength="60" placeholder="Choose or type"></label>
      <label class="field">Location<input name="location" value="<?= e($p['location']) ?>" maxlength="80" placeholder="e.g. Battaramulla"></label>
    </div>
    <div class="row">
      <label class="field">Year<input name="year" value="<?= e($p['year']) ?>" maxlength="12" placeholder="<?= date('Y') ?>"></label>
      <label class="field">Client <small>(optional, only if they agree to be named)</small><input name="client" value="<?= e($p['client']) ?>" maxlength="100"></label>
    </div>
    <datalist id="cats"><?php foreach ($allCats as $c): ?><option value="<?= e($c) ?>"><?php endforeach; ?></datalist>
    <label class="field">Short summary <small>(one or two sentences, shown in large text)</small><textarea name="summary" rows="2" maxlength="300"><?= e($p['summary']) ?></textarea></label>
    <label class="field">Full description <small>(scope, materials, challenges, outcome)</small><textarea name="description" rows="7" maxlength="8000"><?= e($p['description']) ?></textarea></label>
    <div class="checks">
      <label><input type="checkbox" name="published" value="1" <?= !empty($p['published']) ? 'checked' : '' ?>> Published (visible on the website)</label>
      <label><input type="checkbox" name="featured" value="1" <?= !empty($p['featured']) ? 'checked' : '' ?>> ★ Featured (shown first and on the home page)</label>
    </div>
  </div>

  <div class="card">
    <h2>Photos</h2>
    <?php if ($p['images']): ?>
      <p class="hint">Choose the <strong>cover</strong> photo (shown in the portfolio grid). Tick <strong>remove</strong> to delete a photo.</p>
      <div class="photos">
        <?php foreach ($p['images'] as $i => $img): ?>
          <div class="photo">
            <img src="<?= e(img_url($img, 'thumb')) ?>" alt="">
            <label><input type="radio" name="cover" value="<?= e($img['src']) ?>" <?= $i === 0 ? 'checked' : '' ?>> Cover</label>
            <label class="rm"><input type="checkbox" name="remove[]" value="<?= e($img['src']) ?>"> Remove</label>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <label class="drop">
      <input type="file" name="photos[]" accept="image/jpeg,image/png,image/webp" multiple data-photos>
      <strong>+ Add photos</strong>
      <span>JPG, PNG or WebP. You can select several at once. Large photos are resized automatically.</span>
      <span class="drop__list" data-photo-list></span>
    </label>
  </div>

  <div class="savebar">
    <button class="btn" type="submit" data-save><?= $isNew ? 'Add project' : 'Save changes' ?></button>
    <span class="hint" data-status></span>
  </div>
</form>
<?php admin_foot(); ?>
