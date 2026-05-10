<?php

return [
    'routes' => [
        'admin_prefix' => 'halaman',
    ],

    'public' => [
        'enabled' => true,
    ],

    'seo' => [
        'default_meta_title' => 'Halaman',
        'default_meta_description' => null,
    ],

    'blocks' => [
        'allowed' => [
            'hero',
            'rich_text',
            'image',
            'gallery',
            'cta',
            'faq',
            'latest_posts',
            'custom_html',
        ],
    ],
];
