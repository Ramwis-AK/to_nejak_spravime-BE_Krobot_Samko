<?php

return [
    // CORS sa aplikuje na API cesty a Sanctum
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'], // GET, POST, PUT, PATCH, DELETE, OPTIONS

    // povolené originy frontendu (Vite beží na oboch tvaroch)
    'allowed_origins' => [
        'http://localhost:5173',
        'http://127.0.0.1:5173',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // vrátane Authorization a Content-Type

    'exposed_headers' => [],

    'max_age' => 0,

    // false = používame Bearer tokeny (nie cookies), takže netreba credentials
    'supported_credentials' => false,
];