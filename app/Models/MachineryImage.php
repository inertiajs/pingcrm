<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineryImage extends Model
{
    protected $table = 'machinery_images';

    protected $fillable = ['machinery_id', 'thumbnaul', 'full', 'main'];

    protected $casts = [
        'machinery_id' => 'integer',
        'main' => 'boolean',
    ];

    public function machinery()
    {
        return $this->belongsTo(Machinery::class);
    }

    public function getFullAttribute($value)
    {
        if (!is_null($value)) {
            return asset('storage/' . $value);
        }
    }

    public function getStorageFullAttribute($value, array $attributes)
    {
        if (!is_null($attributes['full'])) {
            return $attributes['full'];
        }
        return null;
    }

    // public function full(): CastableAttribute
    // {
    //     return CastableAttribute::make(
    //         get: static function ($value) {
    //             if (!is_null($value)) {
    //                 return asset('storage/' . $value);
    //             }
    //         }
    //     );
    // }
    // public function storageFull(): CastableAttribute
    // {
    //     return CastableAttribute::make(
    //         get: static function ($value, $attributes) {
    //             if (!is_null($attributes['full'])) {
    //                 return $attributes['full'];
    //             }

    //             return null;
    //         }
    //     );
    // }
}
