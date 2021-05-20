<?php

namespace App\Support;

use Illuminate\Support\Collection;

interface FileLoader
{
    public function load();
    public function output() : Collection;
}
