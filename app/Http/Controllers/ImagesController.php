<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

class ImagesController extends Controller
{
    public function show(Filesystem $filesystem, Request $request, $path)
    {
        $server = ServerFactory::create([
            'response' => new LaravelResponseFactory($request),
            'source' => $filesystem->getDriver(),
            'cache' => $filesystem->getDriver(),
            'cache_path_prefix' => '.glide-cache',
            'base_url' => 'img'
        ]);

        return $server->getImageResponse($path, $request->all());
    }
}
