<?php

namespace App;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent
{
    protected $guarded = [];

    public function getPerPage()
    {
        return 10;
    }

    public function resolveRouteBinding($value)
    {
        return $this->where('id', $value)->withTrashed()->first() ?? App::abort(404);
    }
}
