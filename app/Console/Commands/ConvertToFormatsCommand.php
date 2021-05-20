<?php

namespace App\Console\Commands;

use App\Models\ListingsResource;
use App\Support\Loaders\CsvLoader;
use Illuminate\Console\Command;

class ConvertToFormatsCommand extends Command
{
    protected $signature = 'app:convert {file} {format=xml,json} {outputFilename?}';

    protected $description = 'Convert File to different formats';

    public function handle()
    {
        $file = storage_path($this->defaults('file', 'db.csv'));
        $formats = explode(',', $this->defaults('format', 'xml,json'));
        $outputFilename = $this->defaults('outputFilename', 'content');
        $file = (new CsvLoader())->setFilePath($file)->setMapper(new ListingsResource)->load();
        $this->processWriter($formats, $file, $outputFilename);
    }

    public function defaults($key, $default = null)
    {
        return $this->argument($key) ?? $default;
    }

    /**
     * @param $formats
     * @param CsvLoader $file
     * @param string $outputFilename
     */
    protected function processWriter($formats, CsvLoader $file, string $outputFilename): void
    {
        $outputFilename = storage_path($outputFilename);
        foreach ($formats as $format) {
            if (! class_exists($class = sprintf('App\Support\Writers\%sWriter', ucfirst($format))) ) {
                $this->error("The writer {$format} is not available");
                continue;
            }
            $output = (new $class($file, $outputFilename));
            $output->write();
            $this->info("Format {$format} successfully generated, file available in {$output->getFilename()}");
        }
    }
}
