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

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    public function handle()
    {

        $this->jsonFile = ltrim(config('jheckdoc.json_file'),'/');

        $files = $this->getFiles(config('jheckdoc.controllers'));

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
            ['-','-'],
            ['Total', $this->total],
        ]);
    }

    private function getFiles($dir, &$results = array())
    {
        $files = scandir($dir);

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
        $success = 0;
        $failed = 0;
        $total = 0;
        foreach ($tokens as $token) {
            if ($token[0] == T_COMMENT || $token[0] == T_DOC_COMMENT) {
                $line = trim($token[1], ' ');
                if (stripos($line, '@jheckdoc') !== false) {

                    $this->total++;

                    $line = str_replace('/*@jheckdoc', '', $line);
                    $line = str_replace('*/', '', $line);
                    $line = str_replace("\n", '', $line);
                    // $line = str_replace('},]', '}]', $line);
                    // $line = str_replace(',}', '}', $line);
                    $json = json_decode($line);

                    try{
                        $jsonRoute = $json->route;
                        unset($json->route);
                        $this->jheckdoc['routes'][$jsonRoute] = $json;
                        $this->line("✓ $jsonRoute");
                        $this->success++;
                    }
                    catch(\Exception $e){
                        $this->error($e->getMessage());
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
        $this->jheckdoc['version'] = JheckDoc::version();
        $this->jheckdoc['main_url'] = url(config('jheckdoc.url'));
        $this->jheckdoc['server_url'] = rtrim(config('jheckdoc.api_url'), '/');
    }
}
