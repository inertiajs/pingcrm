<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use League\Glide\Server;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use SoftDeletes, Authenticatable, Authorizable;

    protected $casts = [
        'owner' => 'boolean',
    ];

    protected $hidden = ['password'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function expedients_follower()
    {
        return $this->belongsToMany(Expedient::class, 'expedient_user', 'user_id', 'expedient_id');
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getPhotoAttribute()
    {
        return $this->photoUrl(['w' => 40, 'h' => 40, 'fit' => 'crop']);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::needsRehash($password) ? Hash::make($password) : $password;
    }

    public function photoUrl(array $attributes)
    {
        if ($this->photo_path) {
            return URL::to(App::make(Server::class)->fromPath($this->photo_path, $attributes));
        }
    }

    // protected $appends = [
    //     'permissions',
    // ];

    // public function getPermissionsAttribute()
    // {
    //     return [
    //         'expedients' => [
    //             'view' => $this->can('user-admin'),
    //         ],
    //         'templates' => [
    //             'view' => $this->can('user-admin'),
    //         ],
    //         'requirements' => [
    //             'view' => $this->can('user-admin'),
    //         ],
    //         'users' => [
    //             'view' => $this->can('user-admin'),
    //         ],
    //     ];
    // }

    public function isDemoUser()
    {
        return $this->email === 'johndoe@example.com';
    }


    public function scopeOrderByName($query)
    {
        $query->orderBy('last_name')->orderBy('first_name');
    }

    public function scopeWhereRole($query, $role)
    {
        switch ($role) {
            case 'user':
                return $query->where('owner', false);
            case 'owner':
                return $query->where('owner', true);
        }
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        })->when($filters['role'] ?? null, function ($query, $role) {
            $query->whereRole($role);
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
