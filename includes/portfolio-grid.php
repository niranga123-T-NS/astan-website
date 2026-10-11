<?php
defined('APP') or exit;
/** Filterable portfolio grid. Expects $projects and $showBrandFilter. */
$cats = [];
foreach ($projects as $p) {
    if (!empty($p['category'])) {
        $cats[slugify($p['category'])] = $p['category'];
    }
}
asort($cats);
?>
<?php if ($projects): ?>
  <div class="filters reveal" role="group" aria-label="Filter projects">
    <?php if ($showBrandFilter): ?>
      <button class="filter" type="button" data-filter="brand" data-value="all">All work</button>
      <button class="filter" type="button" data-filter="brand" data-value="astan">ASTAN International</button>
      <button class="filter" type="button" data-filter="brand" data-value="ants">ANTS Design</button>
      <span class="filters__sep" aria-hidden="true"></span>
    <?php endif; ?>
    <button class="filter" type="button" data-filter="cat" data-value="all">All categories</button>
    <?php foreach ($cats as $slug => $label): ?>
      <button class="filter" type="button" data-filter="cat" data-value="<?= e($slug) ?>"><?= e($label) ?></button>
    <?php endforeach; ?>
  </div>
  <div class="work-grid">
    <?php foreach ($projects as $p): ?><?= project_card($p, $showBrandFilter) ?><?php endforeach; ?>
  </div>
  <div class="empty-state" data-filter-empty hidden>No projects in this category yet.</div>
<?php else: ?>
  <div class="empty-state">Our portfolio is being updated. New projects will appear here soon.</div>
<?php endif; ?>
