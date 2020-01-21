<?php

namespace App\Http\Controllers;

use League\Glide\Server;

class ImagesController extends Controller
{
    public function __invoke(Server $glide)
    {
        return $this->show($glide);
    }

    public function show(Server $glide)
    {
        return $glide->fromRequest()->response();
    }
}
