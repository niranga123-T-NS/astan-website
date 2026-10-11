<?php
defined('APP') or exit;

/** Inline line icon. */
function icon(string $name): string
{
    static $paths = [
        'invest'  => '<path d="M3 17l6-6 4 4 8-8M14 7h7v7"/>',
        'trade'   => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18a14 14 0 0 1 0-18"/>',
        'service' => '<path d="M4 7h14l-4-4M20 17H6l4 4"/>',
        'mep'     => '<path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 0 0 5.4-5.4l-2.6 2.6-2.4-.6-.6-2.4z"/>',
        'design'  => '<path d="M4 11V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3M2 13a2 2 0 0 1 4 0v2h12v-2a2 2 0 0 1 4 0v5H2zM5 18v2M19 18v2"/>',
        'elec'    => '<path d="M13 2L4 14h7l-1 8 9-12h-7z"/>',
        'estate'  => '<path d="M3 21h18M5 21V7l7-4 7 4v14M9 10h2M13 10h2M9 14h2M13 14h2M10 21v-3h4v3"/>',
        'build'   => '<path d="M3 19h18M5 17a7 7 0 0 1 14 0M12 6v5M9 7.5v3M15 7.5v3"/>',
        'pin'     => '<path d="M12 22s7-6.2 7-12a7 7 0 0 0-14 0c0 5.8 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/>',
        'phone'   => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/>',
        'mail'    => '<path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2zM22 6l-10 7L2 6"/>',
        'id'      => '<path d="M3 5h18v14H3zM7 9h4M7 13h6M15 9h2v4h-2z"/>',
        'arrow'   => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'plan'    => '<path d="M3 3h18v18H3zM3 9h8v12M11 13h10M15 3v10"/>',
        'cube'    => '<path d="M12 2l9 5v10l-9 5-9-5V7zM12 22V12M21 7l-9 5-9-5"/>',
        'lamp'    => '<path d="M9 2h6l3 8H6zM12 10v9M8 22h8"/>',
        'chair'   => '<path d="M6 3h12v8H6zM5 11h14v4H5zM7 15v6M17 15v6"/>',
        'palette' => '<path d="M12 22a10 10 0 1 1 10-10c0 2.8-2.2 4-4 4h-2a2 2 0 0 0-1.5 3.3A2 2 0 0 1 12 22z"/><circle cx="7.5" cy="11" r="1"/><circle cx="10.5" cy="7" r="1"/><circle cx="15.5" cy="7.5" r="1"/>',
        'check'   => '<path d="M5 12l5 5L20 7"/>',
        'whatsapp'=> '<path d="M3 21l1.7-5A9 9 0 1 1 8 19.4z"/><path d="M9 9.5c0 3 2.5 5.5 5.5 5.5l1.2-1.4-2-1-1 .8a4 4 0 0 1-2.1-2.1l.8-1-1-2z"/>',
    ];
    return '<svg class="i" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . ($paths[$name] ?? '') . '</svg>';
}
