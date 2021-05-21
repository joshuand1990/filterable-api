<?php

namespace App\Support\Loaders;

use SplFileObject;

class CsvLoader extends BaseLoader
{
    protected $file;

    /**
     * @return $this
     * @throws \Exception
     */
    public function load() : self
    {
        $this->file = new SplFileObject($this->getFilePath());
        $header = $this->file->fgetcsv();
        while ($this->file->valid() && $line = $this->file->fgetcsv(self::DELIMITER, "\"", self::ESCAPE)) {
            if($this->isInValidLine($line)) {
                continue;
            }
            $line = array_combine($header, $line);
            $this->parse($line);
        }
        return $this;
    }

    /**
     * @param array $line
     * @return bool
     */
    protected function isInValidLine(array $line): bool
    {
        return count($line) === 1 && is_null($line[0]);
    }
}
