<?php

namespace App\Support\Loaders;

class JsonLoader extends BaseLoader
{
    public function load()
    {
        $contents = file_get_contents($this->getFilePath());
        $contents = json_decode($contents);
        foreach ($contents as $ln) {
            $this->parse((array) $ln);
        }
        return $this;
    }
}
