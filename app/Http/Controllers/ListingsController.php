<?php

namespace App\Http\Controllers;

use App\Models\ListingsResource;
use App\Support\Loaders\JsonLoader;
use Illuminate\Http\Response;

class ListingsController extends Controller
{
    public function index()
    {
        $loader = (new JsonLoader())
            ->setFilePath(storage_path('db.json'))->setMapper(new ListingsResource)
            ->load()
        ->when(request()->has('name'), function ($loader) {
            $search = request('name');
            return $loader->filter(function ($item) use ($search) {
                return false !== stripos($item->name, $search);
            });
        })
        ->when(request()->has('discount_percentage'), function ($loader) {
            $search = request('discount_percentage');
            return $loader->filter(function ($item) use ($search) {
                return  $item->discount_percentage == $search;
            });
        });
         return response()->toXmlResponse($loader->toXml("listings"),
             $loader->count() ? Response::HTTP_OK : Response::HTTP_NO_CONTENT);
    }
}
