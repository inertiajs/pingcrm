<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use League\Glide\Server;

class ImagesController extends Controller
{
    public function show(Server $glide)
    {
        return $glide->fromRequest()->response();
    }
    public function files($path)
    {
        return Storage::response("files/$path");
    }
}
