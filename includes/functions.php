<?php
defined('APP') or exit;

const DATA_DIR    = __DIR__ . '/../data';
const PROJECTS_DB = DATA_DIR . '/projects.json';
// Shipped with the site and used only until the first project is saved in the admin panel.
// Your real projects live in data/projects.json, which site updates never overwrite.
const PROJECTS_SAMPLE = DATA_DIR . '/projects.sample.json';
const UPLOAD_DIR  = __DIR__ . '/../uploads/projects';
const UPLOAD_URL  = 'uploads/projects';

/** HTML-escape. */
function e($v): string
{
    return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Site-relative URL, e.g. url('portfolio.php'). */
function url(string $path = ''): string
{
    return BASE_URL . '/' . ltrim($path, '/');
}

function company(string $brand): array
{
    return COMPANIES[$brand] ?? COMPANIES['astan'];
}

function tel(string $phone): string
{
    return 'tel:' . preg_replace('/[^0-9+]/', '', $phone);
}

function brand_label(string $brand): string
{
    return $brand === 'ants' ? 'ANTS Design' : 'ASTAN';
}

/* ---------------- Portfolio storage ---------------- */

function projects_all(): array
{
    $file = is_file(PROJECTS_DB) ? PROJECTS_DB : PROJECTS_SAMPLE;
    if (!is_file($file)) {
        return [];
    }
    $fh = fopen($file, 'r');
    if (!$fh) {
        return [];
    }
    flock($fh, LOCK_SH);
    $json = stream_get_contents($fh);
    flock($fh, LOCK_UN);
    fclose($fh);
    $list = json_decode($json ?: '[]', true);
    return is_array($list) ? $list : [];
}

function projects_save(array $list): bool
{
    usort($list, fn($a, $b) => [$b['year'] ?? '', $b['created'] ?? 0] <=> [$a['year'] ?? '', $a['created'] ?? 0]);
    $json = json_encode(array_values($list), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    $tmp = PROJECTS_DB . '.tmp';
    if (file_put_contents($tmp, $json, LOCK_EX) === false) {
        return false;
    }
    return rename($tmp, PROJECTS_DB);
}

/** Published projects, optionally filtered by brand. */
function projects_published(?string $brand = null): array
{
    $list = array_values(array_filter(projects_all(), function ($p) use ($brand) {
        return !empty($p['published']) && ($brand === null || $p['brand'] === $brand);
    }));
    // Featured projects first, then real projects before samples (usort keeps the order otherwise).
    usort($list, fn($a, $b) => [empty($a['featured']), !empty($a['sample'])] <=> [empty($b['featured']), !empty($b['sample'])]);
    return $list;
}

function projects_featured(?string $brand = null, int $limit = 6): array
{
    $list = projects_published($brand);
    usort($list, fn($a, $b) => (int)!empty($b['featured']) <=> (int)!empty($a['featured']));
    return array_slice($list, 0, $limit);
}

function project_find(string $key, string $field = 'slug'): ?array
{
    foreach (projects_all() as $p) {
        if (($p[$field] ?? null) === $key) {
            return $p;
        }
    }
    return null;
}

function slugify(string $text): string
{
    $s = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $text), '-'));
    return $s !== '' ? substr($s, 0, 60) : 'project';
}

function unique_slug(string $title, string $exceptId = ''): string
{
    $base = slugify($title);
    $slug = $base;
    $taken = [];
    foreach (projects_all() as $p) {
        if ($p['id'] !== $exceptId) {
            $taken[$p['slug']] = true;
        }
    }
    for ($i = 2; isset($taken[$slug]); $i++) {
        $slug = $base . '-' . $i;
    }
    return $slug;
}

/** Image URL for a stored project image, or '' if none. */
function img_url(?array $img, string $size = 'src'): string
{
    if (!$img || empty($img[$size])) {
        return '';
    }
    $path = (string)$img[$size];
    return preg_match('#^(https?:)?//#', $path) ? $path : url($path);
}

function project_cover(array $p): ?array
{
    return $p['images'][0] ?? null;
}

/** Photo stages for interior projects. '' = general photo. */
const STAGES = [
    ''       => 'General',
    'before' => 'Before',
    'design' => 'Design',
    'after'  => 'After',
];

function image_stage(array $img): string
{
    $s = $img['stage'] ?? '';
    return isset(STAGES[$s]) ? $s : '';
}

/** Images grouped by stage, in the order Before → Design → After → General. */
function project_stages(array $p): array
{
    $g = ['before' => [], 'design' => [], 'after' => [], '' => []];
    foreach ($p['images'] ?? [] as $img) {
        $g[image_stage($img)][] = $img;
    }
    return $g;
}

function has_before_after(array $p): bool
{
    $g = project_stages($p);
    return $g['before'] && $g['after'];
}

/* ---------------- Image uploads ---------------- */

/**
 * Validate and store one uploaded image. Returns ['src' => ..., 'thumb' => ...] or an error string.
 * Images are re-encoded as JPEG (removes hidden data such as GPS location) and resized.
 */
function store_upload(array $f)
{
    if (($f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        $codes = [UPLOAD_ERR_INI_SIZE => 'is larger than the server allows', UPLOAD_ERR_FORM_SIZE => 'is too large', UPLOAD_ERR_PARTIAL => 'only partly uploaded'];
        return 'File "' . ($f['name'] ?? '') . '" ' . ($codes[$f['error']] ?? 'could not be uploaded') . '.';
    }
    if (!is_uploaded_file($f['tmp_name'])) {
        return 'Invalid upload.';
    }
    if ($f['size'] > 15 * 1024 * 1024) {
        return 'File "' . $f['name'] . '" is larger than 15 MB.';
    }
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $info = @getimagesize($f['tmp_name']);
    if (!isset($allowed[$mime]) || !$info) {
        return 'File "' . $f['name'] . '" is not a JPG, PNG or WebP image.';
    }
    [$w, $h] = $info;
    if ($w * $h > 40000000) {
        return 'Image "' . $f['name'] . '" is too large (over 40 megapixels). Please resize it first.';
    }
    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }
    $name = date('Ymd') . '-' . bin2hex(random_bytes(6));

    if (!function_exists('imagecreatefromjpeg')) {
        // No GD on the server: keep the original file as-is.
        $file = $name . '.' . $allowed[$mime];
        if (!move_uploaded_file($f['tmp_name'], UPLOAD_DIR . '/' . $file)) {
            return 'Could not save "' . $f['name'] . '". Check that the uploads folder is writable.';
        }
        return ['src' => UPLOAD_URL . '/' . $file, 'thumb' => UPLOAD_URL . '/' . $file];
    }

    @ini_set('memory_limit', '512M');
    $src = match ($mime) {
        'image/jpeg' => @imagecreatefromjpeg($f['tmp_name']),
        'image/png'  => @imagecreatefrompng($f['tmp_name']),
        'image/webp' => @imagecreatefromwebp($f['tmp_name']),
    };
    if (!$src) {
        return 'Could not read image "' . $f['name'] . '".';
    }
    if ($mime === 'image/jpeg' && function_exists('exif_read_data')) {
        $src = auto_rotate($src, $f['tmp_name']);
    }
    $out = [];
    foreach (['src' => [2000, 82, ''], 'thumb' => [900, 78, '-t']] as $key => [$max, $q, $suffix]) {
        $file = $name . $suffix . '.jpg';
        if (!save_resized($src, UPLOAD_DIR . '/' . $file, $max, $q)) {
            imagedestroy($src);
            return 'Could not save "' . $f['name'] . '". Check that the uploads folder is writable.';
        }
        $out[$key] = UPLOAD_URL . '/' . $file;
    }
    imagedestroy($src);
    return $out;
}

function auto_rotate($img, string $path)
{
    $exif = @exif_read_data($path);
    $o = $exif['Orientation'] ?? 1;
    $angle = [3 => 180, 6 => -90, 8 => 90][$o] ?? 0;
    if ($angle) {
        $r = imagerotate($img, $angle, 0);
        if ($r) {
            imagedestroy($img);
            return $r;
        }
    }
    return $img;
}

function save_resized($src, string $dest, int $max, int $quality): bool
{
    $w = imagesx($src);
    $h = imagesy($src);
    $scale = min(1, $max / max($w, $h));
    $nw = max(1, (int)round($w * $scale));
    $nh = max(1, (int)round($h * $scale));
    $dst = imagecreatetruecolor($nw, $nh);
    imagefill($dst, 0, 0, imagecolorallocate($dst, 255, 255, 255)); // flatten transparency on white
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
    imageinterlace($dst, true);
    $ok = imagejpeg($dst, $dest, $quality);
    imagedestroy($dst);
    return $ok;
}

/** Delete a stored image's files (only ever inside the uploads folder). */
function delete_image(array $img): void
{
    foreach (['src', 'thumb'] as $k) {
        if (empty($img[$k]) || strpos($img[$k], UPLOAD_URL . '/') !== 0) {
            continue;
        }
        $file = UPLOAD_DIR . '/' . basename($img[$k]);
        if (is_file($file)) {
            @unlink($file);
        }
    }
}

/* ---------------- Contact form ---------------- */

function start_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    session_name('astan_sess');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => BASE_URL . '/',
        'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function csrf_token(): string
{
    start_session();
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_ok(): bool
{
    start_session();
    return !empty($_SESSION['csrf']) && is_string($_POST['csrf'] ?? null) && hash_equals($_SESSION['csrf'], $_POST['csrf']);
}

function clean_line($v, int $max): string
{
    $v = str_replace(["\r", "\n", "\0"], ' ', trim((string)$v));
    return mb_substr(strip_tags($v), 0, $max);
}

/**
 * Handle a contact-form POST for a brand. Returns 'sent', 'error' or null (no submission).
 */
function handle_contact(string $brand): ?string
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ($_POST['form'] ?? '') !== 'contact') {
        return null;
    }
    if (!empty($_POST['website'])) {     // spam trap
        return 'sent';
    }
    $name    = clean_line($_POST['name'] ?? '', 100);
    $email   = clean_line($_POST['email'] ?? '', 150);
    $phone   = clean_line($_POST['phone'] ?? '', 30);
    $service = clean_line($_POST['service'] ?? 'General enquiry', 80);
    $message = mb_substr(trim(strip_tags((string)($_POST['message'] ?? ''))), 0, 5000);

    if ($name === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'error';
    }
    $c = company($brand);
    $subject = '=?UTF-8?B?' . base64_encode('Website enquiry (' . $c['short'] . '): ' . $service . ' - ' . $name) . '?=';
    $body = "New enquiry from the {$c['short']} website\n\n"
          . "Name:    $name\nEmail:   $email\nPhone:   $phone\nService: $service\n\nMessage:\n$message\n";
    $headers = "From: {$c['short']} Website <" . MAIL_FROM . ">\r\n"
             . "Reply-To: $email\r\n"
             . "Content-Type: text/plain; charset=UTF-8\r\n";
    return @mail($c['email'], $subject, $body, $headers, '-f' . MAIL_FROM) ? 'sent' : 'error';
}
