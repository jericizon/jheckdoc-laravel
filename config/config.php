<?php

return [
    'controllers' => env('JHECKDOC_CONTROLLERS', base_path('app/Http/Controllers')),
    'json_file' => 'jheckdoc/api-docs.json',
    'url' => env('JHECKDOC_URL', 'api/documentation'),
    'api_url' => env('JHECKDOC_API', ''),
    'jheckdoc_assets' => 'jheckdoc-assets'
];
