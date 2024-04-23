<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function getNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function scopeOrderByName($query): void
    {
        $query->orderBy('last_name')->orderBy('first_name');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (! count($filters)) {
            return $query;
        }

        if (@$filters['search']) {
            $query->where(function (Builder $query) use ($filters) {
                $query->whereAny(['first_name', 'last_name', 'email'], 'like', '%'.$filters['search'].'%')
                    ->orWhereHas('organization', function (Builder $query) use ($filters) {
                        $query->where('name', 'like', '%'.$filters['search'].'%');
                    });
            });
        }

        if (@$filters['trashed']) {
            if ($filters['trashed'] === 'with') {
                $query->withTrashed();
            } elseif ($filters['trashed'] === 'only') {
                $query->onlyTrashed();
            }
        }

        return $query;
    }
}
