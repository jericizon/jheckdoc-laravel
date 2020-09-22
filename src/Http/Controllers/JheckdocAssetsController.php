<?php

namespace JheckDoc\JheckDocLaravel\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class JheckdocAssetsController extends Controller
{


    public function assetDist($file)
    {
        return dirname(__FILE__) .'/../../../dist/'. $file;
    }

    public function index($asset)
    {
        try {

            if($asset === 'fetchdata.json'){
                $jsonFile = ltrim(config('jheckdoc.json_file'),'/');
                $fileContent = '';
                if(Storage::exists($jsonFile)) $fileContent = Storage::get($jsonFile);
                return (new Response(
                    $fileContent, 200, [
                        'Content-Type' => 'application/javascript'
                    ]))
                    ->withHeaders([
                        'Access-Control-Allow-Origin' => '*',
                        'Access-Control-Allow-Headers' => '*',
                        'Access-Control-Allow-Methods' => '*',
                    ]);
            }
            else{
                $contentType = (pathinfo($asset))['extension'];
                if($contentType === 'css' || $contentType === 'js') $asset = "$contentType/$asset";

                $path = self::assetDist($asset);

                $fileContent = file_get_contents($path);

                if($asset === 'js/app.js'){
                    // replace for vuejs routing
                    $baseUrl = config('jheckdoc.url');
                    $fileContent = str_replace('base:"/jheckdoc"', 'base:"'.$baseUrl.'"', $fileContent);
                }

                return (new Response(
                    $fileContent, 200, [
                        'Content-Type' => (pathinfo($asset))['extension'] == 'css' ?
                            'text/css' : 'application/javascript',
                    ]
                ))->setSharedMaxAge(31536000)
                    ->setMaxAge(31536000)
                    ->setExpires(new \DateTime('+1 year'));
            }


        } catch (Exception $exception) {
            return abort(404, $exception->getMessage());
        }
    }
}
