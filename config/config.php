<?php

return [
    /**
     * Directory where to scan the codeblock annotations
     */
    'controllers' => env('JHECKDOC_CONTROLLERS', base_path('app/Http/Controllers')),

    /**
     * Generated json file, where jheckdoc app will get the information
     */

    'json_file' => 'jheckdoc/api-docs.json',

    /**
     * Default url to view jheckdoc dashboard
     */

    'url' => env('JHECKDOC_URL', 'api/documentation'),

    /**
     * Jheckdoc asset files
     */
    'jheckdoc_assets' => 'jheckdoc-assets'
];
