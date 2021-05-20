<?php

namespace App\Support\Loaders;

use Exception;
use App\Support\FileLoader;
use App\Models\BaseResource;
use Illuminate\Support\Collection;
use App\Support\Contracts\Xmlable;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

abstract class BaseLoader extends Collection implements FileLoader, Xmlable, Jsonable
{
    public const ESCAPE = "\n";
    public const DELIMITER = ',';

    /**
     * @var BaseResource
     */
    protected $dto_mapper;
    protected $file_path = null;

    public function toXml($root = 'root') : string
    {
        $xmls = array_map(function ($value) {
            if ($value instanceof Xmlable) {
                return $value->toXml();
            }
            return $value;
        }, $this->all());
        return sprintf("<%s>%s</%s>", $root, implode($xmls, ''), $root);
    }

    /**
     * @param string $file_path
     * @return self
     * @throws FileNotFoundException
     */
    public function setFilePath(string $file_path) : self
    {
        if (!File::exists($file_path) and !File::isFile($file_path)) {
            throw new FileNotFoundException();
        }
        $this->file_path = $file_path;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function getFilePath() : string
    {
        if(is_null($this->file_path)) {
            throw new Exception("File Path not set");
        }
        return $this->file_path;
    }

    public function setMapper(BaseResource $dto_mapper) : self
    {
        $this->dto_mapper = $dto_mapper;
        return $this;
    }

    /**
     * @param $line
     */
    protected function parse($line) : void
    {
        $dto = new $this->dto_mapper;
        foreach ($this->dto_mapper->headers() as $ln) {
            if (property_exists($dto, $ln)) {
                $dto->{$ln} = $line[$ln];
            }
        }
        $this->push($dto);
    }

    public function output() : Collection
    {
        return $this;
    }

    public function getCollection() : Collection
    {
        return $this;
    }
}
