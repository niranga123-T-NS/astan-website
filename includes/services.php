<?php
defined('APP') or exit;

/** Divisions and services — edit wording here and every page updates. */
const DIVISIONS = [
    'engineering' => [
        'title' => 'Engineering & MEP',
        'icon'  => 'elec',
        'intro' => 'Mechanical, electrical and plumbing contracting and independent electrical engineering advice for residential, commercial and industrial projects.',
        'services' => ['mep', 'electrical'],
    ],
    'interiors' => [
        'title' => 'Interiors',
        'icon'  => 'design',
        'intro' => 'Designed by ANTS Design Ventures, our design arm, and built by ASTAN. Creative design and site delivery, managed by one team.',
        'services' => ['interior-design', 'interior-construction'],
    ],
    'property' => [
        'title' => 'Property & Investments',
        'icon'  => 'estate',
        'intro' => 'Real estate services and carefully assessed investments in property, construction and trade.',
        'services' => ['real-estate', 'investments'],
    ],
    'trade' => [
        'title' => 'International Trade',
        'icon'  => 'trade',
        'intro' => 'Import and export of products and cross-border delivery of professional and technical services.',
        'services' => ['import-export', 'service-trade'],
    ],
];

const SERVICES = [
    'mep' => [
        'title' => 'MEP Contracts',
        'icon'  => 'mep',
        'text'  => 'Mechanical, electrical and plumbing works delivered from design coordination through installation, testing, commissioning and handover — with a single accountable contractor.',
        'items' => ['Electrical installations & power distribution', 'Plumbing, water supply & drainage', 'HVAC & ventilation systems', 'Fire detection & protection', 'Testing, commissioning & handover', 'Planned maintenance support'],
    ],
    'electrical' => [
        'title' => 'Electrical Consultancy',
        'icon'  => 'elec',
        'text'  => 'Independent, practical electrical engineering advice that helps owners, developers and contractors make safe, efficient and compliant decisions.',
        'items' => ['Load assessments & system design', 'Drawings, specifications & BOQs', 'Energy-efficiency reviews', 'Tender evaluation', 'Site supervision & inspection', 'Compliance & safety audits'],
    ],
    'interior-design' => [
        'title' => 'Interior Design',
        'icon'  => 'palette',
        'by'    => 'ants',
        'text'  => 'Led by ANTS Design Ventures. Considered, functional interiors designed around the people who use them, presented with clear drawings and 3D visualisation before work begins.',
        'items' => ['Space planning & layouts', 'Concept design & 3D visualisation', 'Material, finish & colour selection', 'Lighting design', 'Furniture, joinery & décor', 'Design-and-build delivery'],
    ],
    'interior-construction' => [
        'title' => 'Interior Construction',
        'icon'  => 'build',
        'text'  => 'Turnkey fit-out and interior construction for homes, offices, retail and hospitality spaces. Built to specification, on schedule and to a high standard of finish.',
        'items' => ['Office & commercial fit-outs', 'Partitions, ceilings & flooring', 'Wall finishes & cladding', 'Custom joinery & furniture', 'Renovation & refurbishment', 'Project management'],
    ],
    'real-estate' => [
        'title' => 'Real Estate',
        'icon'  => 'estate',
        'text'  => 'Support across the property lifecycle, from finding the right land or building to developing, improving and leasing it.',
        'items' => ['Property sales & purchases', 'Land & property sourcing', 'Development advisory', 'Property improvement & renovation', 'Rental & leasing support', 'Valuation coordination'],
    ],
    'investments' => [
        'title' => 'Investments',
        'icon'  => 'invest',
        'text'  => 'Identifying and structuring sound opportunities in property, construction and trade, with a long-term, partnership-driven approach.',
        'items' => ['Property & development investments', 'Joint ventures & partnerships', 'Trade investments', 'Opportunity assessment', 'Feasibility studies', 'Investor liaison'],
    ],
    'import-export' => [
        'title' => 'Import & Export of Products',
        'icon'  => 'trade',
        'text'  => 'Reliable sourcing and international trade of products, connecting Sri Lankan and overseas suppliers and buyers through dependable logistics.',
        'items' => ['Product sourcing & procurement', 'Supplier identification & vetting', 'Export of Sri Lankan products', 'Construction & electrical materials', 'Shipping & logistics coordination', 'Customs documentation support'],
    ],
    'service-trade' => [
        'title' => 'Service Exports & Imports',
        'icon'  => 'service',
        'text'  => 'Cross-border delivery of professional and technical services, bringing international expertise to Sri Lanka and taking Sri Lankan expertise abroad.',
        'items' => ['Engineering & technical services', 'Design & consultancy services', 'Skilled project teams', 'Partnerships with overseas firms', 'Outsourced project support', 'Market-entry assistance'],
    ],
];

/** ANTS Design Ventures disciplines. */
const ANTS_SERVICES = [
    ['palette', 'Interior Design', 'Complete interior design for homes, offices and commercial spaces, from first concept to final styling.'],
    ['plan', 'Space Planning', 'Layouts that make every square metre work harder, improving flow, light and function.'],
    ['cube', '3D Visualisation', 'Photo-realistic renders and walkthroughs so you can see the space before it is built.'],
    ['lamp', 'Lighting & Finishes', 'Lighting schemes, materials, colours and textures chosen to work together.'],
    ['chair', 'Furniture & Joinery', 'Custom furniture, built-in joinery and carefully sourced pieces that fit the design.'],
    ['build', 'Design & Build', 'Designs delivered on site with ASTAN International, so one team handles design and construction.'],
];
