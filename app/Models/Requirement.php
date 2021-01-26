<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Requirement extends Model
{

    use SoftDeletes;


    public function expedients()
    {
        return $this->belongsToMany(Expedient::class, 'documents',  'requirement_id', 'expedient_id',)
            ->as('document')
            ->using(Document::class)
            ->withPivot('id', 'status_id', 'commentary', 'until_valid')
            ->withTimestamps();
    }

    public function scopeOrderByName($query)
    {
        $query->orderBy('name');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
