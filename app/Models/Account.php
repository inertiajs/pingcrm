<?php

namespace App\Models;

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

    public function educations()
    {
        return $this->hasMany(Education::class);
    }


    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    public function experiences()
    {
        return $this->hasMany(Address::class);
    }

    public function banks()
    {
        return $this->hasMany(Bank::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
