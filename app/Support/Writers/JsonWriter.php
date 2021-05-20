<?php


namespace App\Support\Writers;


use Illuminate\Contracts\Support\Jsonable;

class JsonWriter extends BaseWriter
{
    protected $file;
    protected $filename;
    protected $extension = 'json';

    public function __construct(Jsonable $file, $filename)
    {
        $this->file = $file;
        $this->filename = $filename;
    }

    public function toConvert() : string
    {
        return $this->file->toJson();
    }
}
