<?php

namespace JheckDoc\JheckDocLaravel\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

use JheckDoc;

class JheckdocGenerate extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'jheckdoc:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Jheckdoc generate documentation files.';

    protected $jheckdoc = [];

    protected $jsonFile;
    protected $success = 0;
    protected $failed = 0;
    protected $total = 0;
    protected $jheckdocInfoIsMissing = true;

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    public function handle()
    {

        $this->jsonFile = ltrim(config('jheckdoc.json_file'), '/');

        $files = $this->getFiles(config('jheckdoc.controllers'));

        if(!$files) return $this->error("Unable to scan files under diretory: " .config('jheckdoc.controllers') );

        $this->createJheckDocApp();

        // scan and read annotations
        foreach ($files as $file) {
            $this->scanComments($file);
        }

        sleep(1);
        $this->createJson($this->jheckdoc);

        $this->table(['Label', 'Count'], [
            ['Success', $this->success],
            ['Failed', $this->failed],
            ['-', '-'],
            ['Total', $this->total],
        ]);

        if($this->jheckdocInfoIsMissing){
            $this->comment('Warning: one of the requirement is missing [@jheckdocInfo]. https://github.com/jericizon/jheckdoc-laravel/tree/demo-page#api-documentation-detail-information');
        }

        $this->line("File created: " . Storage::path( str_replace('/', DIRECTORY_SEPARATOR, $this->jsonFile)));
    }

    private function getFiles($dir, &$results = array())
    {
        $files = scandir($dir);

        if(count($files) === 0) return;

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                $this->getFiles($path, $results);
                $results[] = $path;
            }
        }

        return $results;
    }

    private function scanComments($file)
    {

        if (!file_exists($file) || !is_file($file)) return;

        $tokens = token_get_all(file_get_contents($file));

        foreach ($tokens as $token) {
            if ($token[0] == T_COMMENT || $token[0] == T_DOC_COMMENT) {
                $line = trim($token[1], ' ');

                if (stripos($line, '@jheckdocInfo') !== false) {
                    try {
                        $line = str_replace('/*@jheckdocInfo', '', $line);
                        $line = str_replace('*/', '', $line);
                        $line = str_replace("\n", '', $line);
                        $json = json_decode($line);

                        if (is_null($json)) {
                            $this->error('@jheckdocInfo detected, but failed to parse the json.');
                        } else {
                            $this->line("[✓] @jheckdocInfo added");
                            $this->jheckdoc['info'] = $json;
                            $this->jheckdocInfoIsMissing = false;
                        }
                    } catch (\Exception $e) {
                        $this->error($e->getMessage());
                    }
                } else if (stripos($line, '@jheckdoc') !== false) {

                    $this->total++;

                    $line = str_replace('/*@jheckdoc', '', $line);
                    $line = str_replace('*/', '', $line);
                    $line = str_replace("\n", '', $line);
                    $json = json_decode($line);

                    try {
                        $jsonRoute = $json->route;
                        $method = strtolower($json->method);

                        unset($json->route);
                        unset($json->method);
                        $this->jheckdoc['routes'][$jsonRoute][$method] = $json;
                        $this->line("[✓] $jsonRoute");
                        $this->success++;
                    } catch (\Exception $e) {
                        // $this->error($e->getMessage());
                        $error = substr(str_replace('  ', '', $line), 0 , 100);
                        $this->error("[X] Failed to parse json: {$error}...");
                        $this->failed++;
                    }
                }
            }
        }
    }

    private function createJson($json)
    {
        // Delete json File
        Storage::put($this->jsonFile, json_encode($json));
    }

    private function createJheckDocApp()
    {
        $this->jheckdoc['jhekdoc'] = JheckDoc::version();
        $this->jheckdoc['main_url'] = url(config('jheckdoc.url'));
    }
}
