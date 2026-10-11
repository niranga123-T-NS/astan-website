<?php
require __DIR__ . '/_lib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_ok()) {
    $_SESSION = [];
    session_regenerate_id(true);
    session_destroy();
}
redirect('admin/');
