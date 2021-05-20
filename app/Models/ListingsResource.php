<?php


namespace App\Models;


use App\Support\Contracts\Xmlable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class ListingsResource implements BaseResource, Jsonable, Arrayable, Xmlable
{
    public $id;
    public $name;
    public $image;
    public $discount_percentage;

    public function headers() : array
    {
        return array_keys((array) $this);
    }
    public function block()
    {
        return "items";
    }
    public function toJson($options = 0)
    {
        return json_encode((array) $this);
    }

    public function toArray()
    {
        return (array) $this;
    }

    public function toXml() : string
    {
        $xml = [];
        foreach ($this->headers() as $header) {
            $xml[] = sprintf("<%s>%s</%s>", $header, $this->{$header}, $header);
        }
        return sprintf("<listing>%s</listing>", implode($xml, ""));
    }
}
