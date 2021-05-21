<?php


namespace App\Support\Contracts;


interface Xmlable
{
    /**
     * Get the instance in Xml format
     * @return string
     */
    public function toXml() : string;
}
