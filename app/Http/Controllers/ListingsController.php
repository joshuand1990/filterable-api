<?php

namespace App\Http\Controllers;

use App\Models\ListingsResource;
use App\Support\Loaders\JsonLoader;
use Illuminate\Http\Response;

class ListingsController extends Controller
{
    /**
     * @return \Laravel\Lumen\Application|mixed
     */
    protected function getFilePath()
    {
        return config('csv.file');
    }

    /**
     * @return JsonLoader
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getData() : JsonLoader
    {
        return (new JsonLoader())
            ->setFilePath($this->getFilePath())->setMapper(new ListingsResource)
            ->load();
    }

    public function index()
    {
        $loader = $this->getData()
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

    public function show($id)
    {
        $loader = $this->getData()->where('id', '=', $id);
        if($loader->count() < 1) {

            return response()->toXmlResponse("<error> No Data found.</error>", Response::HTTP_NO_CONTENT);
        }
        return response()->toXmlResponse($loader->toXml("listings"), Response::HTTP_OK );
    }
}
