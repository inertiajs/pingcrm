<?php

namespace App\Models;

use App\Models\Maintenance\Issue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    /**
     * Get all of the agencies for the Area
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agencies()
    {
        return $this->hasMany(Organization::class, 'area_id');
    }
    /**
     * The issues that belong to the Area
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function issues()
    {
        return $this->belongsToMany(Issue::class, 'issue_zone', 'area_id', 'issue_id');
    }
}
