<?php

namespace App\Support\Loaders;

class JsonLoader extends BaseLoader
{
    /**
     * @return $this
     * @throws \Exception
     */
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
