<?php

namespace App\Models\Maintenance;

use App\Models\Area;
use App\Models\Arrondissement;
use App\Models\Commune;
use App\Models\Department;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Issue extends Model
{
    use HasFactory, SoftDeletes;

    public function zones()
    {
        $zones = DB::table('issue_zone')
            ->where('issue_id', '=', $this->id)
            ->orderBy('issue_id')
            ->get();

        $zones->map(function($z) {
            if($z->departement_id) $z->departement = Department::find($z->departement_id);
            if($z->commune_id) $z->commune = Commune::find($z->commune_id);
            if($z->arrondissement_id) $z->arrondissement = Arrondissement::find($z->arrondissement_id);
            if($z->area_id) $z->area = Area::find($z->area_id);
        });

        return $zones;
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->whereHas('zone', function(Builder $subQuery) use ($search) {
                $subQuery->where('lib_area', 'like', '%'.$search.'%');
            });
        })->when($filters['type'] ?? null, function ($query, $type) {
            if ($type === 'issue') {
                $query->where('type', 'issue');
            } elseif ($type === 'maintenance') {
                $query->where('type', 'maintenance');
            }
        });
    }
}
