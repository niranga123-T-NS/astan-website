<?php
defined('APP') or exit;

/** Portfolio card. $showBrand adds the ASTAN / ANTS tag. */
function project_card(array $p, bool $showBrand = true): string
{
    $cover = project_cover($p);
    $href  = url('project.php?p=' . rawurlencode($p['slug']));
    $img   = $cover
        ? '<img src="' . e(img_url($cover, 'thumb')) . '" alt="' . e($p['title']) . '" loading="lazy">'
        : '<div class="ph ph--' . e($p['brand']) . '" aria-hidden="true"></div>';
    $meta = array_filter([$p['category'] ?? '', $p['location'] ?? '', $p['year'] ?? '']);
    return '<a class="work-card" href="' . $href . '" data-brand="' . e($p['brand']) . '" data-cat="' . e(slugify($p['category'] ?? '')) . '">'
        . '<div class="work-card__img">' . $img
        . ($showBrand ? '<span class="work-card__brand work-card__brand--' . e($p['brand']) . '">' . e(brand_label($p['brand'])) . '</span>' : '')
        . (!empty($p['sample']) ? '<span class="work-card__sample">Sample</span>' : '')
        . (has_before_after($p) ? '<span class="work-card__ba">Before &amp; After</span>' : '')
        . '</div>'
        . '<div class="work-card__body"><h3>' . e($p['title']) . '</h3>'
        . '<p>' . e(implode(' · ', $meta)) . '</p></div>'
        . '</a>';
}
