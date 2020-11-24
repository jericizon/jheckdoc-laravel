<?php

namespace JheckDoc\JheckDocLaravel;

use Illuminate\Support\Facades\Storage;

class JheckDoc
{

    public static function version()
    {
        return 'v1.1.1';
    }


    public function installStyles()
    {
        $files = [
            'chunk-vendors.css',
            'app.css',
        ];

        $assetUrl = trim(config('jheckdoc.jheckdoc_assets'), '/');

        $content = '';

        foreach($files as $file){
            if(file_exists(__DIR__ . "/../dist/css/$file")){
                $content .= '<link rel="stylesheet" href="'.url("{$assetUrl}/{$file}").'?version='.self::version().'">';
            }
        }

        return $content;
    }

    public function installScripts()
    {
        $files = [
            'chunk-vendors.js',
            'app.js',
        ];

        $assetUrl = trim(config('jheckdoc.jheckdoc_assets'), '/');

        $jheckDoc = json_encode([
            'asset_url' => url($assetUrl),
        ]);

        $content = '<script>window.__JHECKDOC__ = '.$jheckDoc.'</script>';

        foreach($files as $file){
            if(file_exists(__DIR__ . "/../dist/js/$file")){
                $content .= '<script src="'.url("{$assetUrl}/{$file}").'?version='.self::version().'"></script>';
            }
        }

        return $content;
    }
}
