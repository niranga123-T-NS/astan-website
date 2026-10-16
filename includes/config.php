<?php
// ASTAN International — site settings.
// Edit the values below, save, and re-upload this file.
defined('APP') or exit;

// If the site lives in a sub-folder (e.g. https://example.com/new/), set BASE_URL to '/new'.
// For a normal install directly in public_html leave it as ''.
const BASE_URL = '';
const SITE_URL = 'https://www.astan-int.lk';   // used for search engines / sharing links

const COMPANIES = [
    'astan' => [
        'name'    => 'ASTAN International (Pvt) Ltd',
        'short'   => 'ASTAN International',
        'reg'     => 'PV 00348027',
        'email'   => 'info@astan-int.lk',
        'web'     => 'www.astan-int.lk',
        'logo'    => 'assets/img/logo-mark.svg',
    ],
    'ants' => [
        'name'    => 'ANTS Design Ventures',
        'short'   => 'ANTS Design Ventures',
        'reg'     => 'WC 20949',
        'email'   => 'info@antsdv.lk',
        'web'     => 'www.antsdv.lk',
        'logo'    => 'assets/img/ants-logo.svg',
    ],
];

const ADDRESS = '318/4D, Sirinanda Jothikarama Road, Thalawathugoda, Sri Lanka';
const PHONES  = ['+94 778 844 346', '+94 754 649 083'];
const WHATSAPP = '94778844346';   // number used for the WhatsApp button (country code, no +)

// Contact form "From" address. Must be a mailbox on your own domain for GoDaddy to deliver it.
const MAIL_FROM = 'website@astan-int.lk';

// Admin panel (/admin). The initial password was given to you separately.
// You can change it any time from Admin → Change password (the new one is stored in data/admin.json).
const ADMIN_PASSWORD_HASH = '$2y$10$xgkHcTvuTRzeB0OLtymkRe.jKInAqKUEtZKdklwWk5enHaYzuLHBu';

// Portfolio categories suggested in the admin panel (you can also type your own).
const CATEGORIES = [
    'astan' => ['MEP Contracts', 'Electrical', 'Interior Construction', 'Real Estate', 'Import & Export', 'Investments', 'Other'],
    'ants'  => ['Residential Interiors', 'Commercial Interiors', 'Office Interiors', 'Education', 'Hospitality', 'Retail', '3D Visualisation', 'Furniture & Joinery', 'Architecture & Planning', 'Other'],
];
