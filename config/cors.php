<?php

return [

    'paths' => ['api/*', 'alumnos', '*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://prueba1-h7gbhxdmbeeyfbf5.eastus2-01.azurewebsites.net',
        'https://prueba1-h7gbhxdmbeeyfbf5.eastus2-01.azurestaticapps.net',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 86400,

    'supports_credentials' => false,

];
