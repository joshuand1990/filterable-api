<?php

namespace App\Providers;

use Flipbox\LumenGenerator\LumenGeneratorServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Lumen\Http\ResponseFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if(!$this->app->environment(['production', 'prod'])) {
            $this->app->register(LumenGeneratorServiceProvider::class);
        }

        Request::macro('wantsXml', function (){
            $acceptable = $this->getAcceptableContentTypes();
            foreach ($acceptable as $ln) {
                if(Str::contains($ln, ['/xml', '+xml'])) { return true; }
            }
            return false;
        });

        ResponseFactory::macro('toXmlResponse', function ($xml = "", $status = Response::HTTP_OK) {
            return response(sprintf('<?xml version="1.0" encoding="utf-8"?>%s', $xml),
                $status,
                [ 'Content-Type' => 'application/xml', 'charset' => 'utf-8' ]);
        });
    }
}
