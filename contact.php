<?php
// ASTAN International — contact form handler (works on GoDaddy cPanel / Linux hosting)

// ---- Settings ----
$to   = 'info@astan-int.lk';          // where enquiries are delivered
$from = 'website@astan-int.lk';       // must be an address on your own domain
$back = 'contact.html';

function go($status) {
    global $back;
    header('Location: ' . $back . '?status=' . $status . '#form-' . ($status === 'sent' ? 'ok' : 'err'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . $back);
    exit;
}

// Spam trap: real visitors never fill the hidden "website" field
if (!empty($_POST['website'])) {
    go('sent');
}

function clean($v, $max) {
    $v = trim((string)$v);
    $v = str_replace(["\r", "\n", "%0a", "%0d"], ' ', $v);   // block header injection
    return mb_substr(strip_tags($v), 0, $max);
}

$name    = clean($_POST['name'] ?? '', 100);
$email   = clean($_POST['email'] ?? '', 150);
$phone   = clean($_POST['phone'] ?? '', 30);
$service = clean($_POST['service'] ?? 'general', 50);
$message = mb_substr(trim(strip_tags((string)($_POST['message'] ?? ''))), 0, 5000);

if ($name === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    go('error');
}

$subject = 'Website enquiry: ' . $service . ' - ' . $name;
$body  = "New enquiry from the ASTAN International website\n\n";
$body .= "Name:    $name\n";
$body .= "Email:   $email\n";
$body .= "Phone:   $phone\n";
$body .= "Service: $service\n\n";
$body .= "Message:\n$message\n";

$headers  = "From: ASTAN Website <$from>\r\n";
$headers .= "Reply-To: $name <$email>\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

go(mail($to, $subject, $body, $headers, '-f' . $from) ? 'sent' : 'error');
