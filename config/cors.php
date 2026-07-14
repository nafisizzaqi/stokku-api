<?php

return [
    'paths' => ['api/*'],
    'allowed_origins' => ['http://localhost:3000', 'http://localhost:5173', 'http://localhost:8000'],
    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true
];