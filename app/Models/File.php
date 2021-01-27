<?php

namespace App\Models;

use Illuminate\Support\Facades\URL;

class File extends Model
{

    public function document()
    {
        return $this->belongsTo(Document::class, 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function getPathAttribute()
    {
        return $this->pathURL();
    }

    public function pathURL()
    {
        if ($this->file_path) {
            return URL::to($this->file_path);
        }
    }

    protected $appends = [
        'path',
    ];
}
