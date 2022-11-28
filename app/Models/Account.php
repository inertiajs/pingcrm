<?php

namespace App\Models;

use App\Models\Maintenance\Issue;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function issues()
    {
        return $this->hasManyThrough(Issue::class, Organization::class);
    }
}
