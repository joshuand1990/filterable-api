<?php

namespace App\Support\Writers;

use App\Support\Contracts\Xmlable;

class XmlWriter extends BaseWriter
{
    /**
     * @var Xmlable
     */
    protected $file;
    protected $filename;
    protected $extension = 'xml';

    public function __construct(Xmlable $file, $filename)
    {
        $this->file = $file;
        $this->filename = $filename;
    }

    public function toConvert() : string
    {
        return $this->file->toXml();
    }
}
