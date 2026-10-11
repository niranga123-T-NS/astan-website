<?php
require __DIR__ . '/includes/bootstrap.php';
header('Content-Type: application/xml; charset=utf-8');

$pages = ['', 'about.php', 'services.php', 'portfolio.php', 'contact.php', 'ants/', 'ants/portfolio.php'];
foreach (projects_published() as $p) {
    if (empty($p['sample'])) {
        $pages[] = 'project.php?p=' . rawurlencode($p['slug']);
    }
}
echo '<?xml version="1.0" encoding="UTF-8"?>', "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', "\n";
foreach ($pages as $path) {
    echo '  <url><loc>', e(SITE_URL . '/' . $path), '</loc></url>', "\n";
}
echo '</urlset>', "\n";
