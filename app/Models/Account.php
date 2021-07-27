<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }


    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }
    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }
    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function followups()
    {
        return $this->hasMany(Followup::class);
    }


    public function officeRule()
    {
        return $this->hasMany(OfficeRule::class);
    }




    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    public function ruleCategory()
    {
        return $this->hasMany(RuleCategory::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function banks()
    {
        return $this->hasMany(Bank::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function holidays()
    {
        return $this->hasMany(Holiday::class);
    }
}
