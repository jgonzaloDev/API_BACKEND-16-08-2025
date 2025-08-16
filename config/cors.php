<?php

return [

    'paths' => ['api/*', 'alumnos', '*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://135.222.162.196',
        'https://app-dojo.com',
        'https://api-backend-dojo.azurewebsites.net',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 86400,

    'supports_credentials' => false,

];
