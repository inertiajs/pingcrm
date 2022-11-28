<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    // protected $with = ['arrondissements'];
    
    /**
     * Get all of the arrondissements for the Commune
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function arrondissements()
    {
        return $this->hasMany(Arrondissement::class);
    }
}
