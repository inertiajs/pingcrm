<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Expedient extends Model
{
    use SoftDeletes;

    public function requirements()
    {
        return $this->belongsToMany(Requirement::class, 'documents', 'expedient_id', 'requirement_id')
            ->as('document')
            ->using(Document::class)
            ->withPivot('id', 'status_id', 'commentary', 'until_valid')
            ->withTimestamps();
    }

    public function owner_user()
    {
        return $this->hasOne(User::class, 'id', 'owner_user_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function follower_users()
    {
        return $this->belongsToMany(User::class, 'expedient_user', 'expedient_id', 'user_id')
            ->withTimestamps();
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    // 
    public function scopeOrderByName($query)
    {
        $query->orderBy('name');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
                ->orWhereHas('owner_user', function ($query) use ($search) {
                    $query->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
        })->when(
            $filters['folio'] ?? null,
            function ($query, $folio) {
                $query->where('id', 'like', $folio);
            }
        )->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    public function scopeOwnerOrFollowerUser($query, User $user)
    {
        if ($user->owner) {
            return $query;
        } else {
            $query->when(
                $user->id ?? null,
                function ($query, $user_id) {
                    $query->where(function ($query) use ($user_id) {
                        $query->where('owner_user_id', $user_id)->orWhere('user_id', $user_id);
                    })->orWhereHas('follower_users', function ($query) use ($user_id) {
                        return $query->whereIn('user_id', [$user_id]);
                    });
                }
            );
        }
    }
}
