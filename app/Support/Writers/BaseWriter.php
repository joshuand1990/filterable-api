<?php

namespace App\Support\Writers;
use Illuminate\Support\Facades\File;

abstract class BaseWriter
{
    protected $file;
    protected $filename;
    protected $extension = 'txt';

    public function getExtension() : string
    {
        return $this->extension;
    }
    public function getFilename() : string
    {
        return sprintf("%s.%s", $this->filename, $this->getExtension());
    }

    public abstract function toConvert() : string ;

    public function write()
    {
        return $this->put($this->getFilename(), $this->toConvert());
    }
    protected function put(string $path, string $contents, bool $lock = false)
    {
        return File::put($path, $contents, $lock);
    }
}
