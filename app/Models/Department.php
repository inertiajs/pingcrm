<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

     /**
     * Get all of the communes for the Department
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function communes()
    {
        return $this->hasMany(Commune::class);
    }
}
