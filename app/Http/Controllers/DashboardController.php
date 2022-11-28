<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Maintenance\Issue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        if (Request::filled('search')) {
            $search = Request::input('search');
    
            // // Query in communes
            // $comQuery = DB::table('communes')
            //                 ->where('lib_com', 'like', "%{$search}%")
            //                 ->join('arrondissements', function($join) {
            //                     $join->on('communes.id', '=', 'arrondissements.commune_id')
            //                         ->join('areas', 'arrondissements.id', '=', 'areas.arrondissement_id');
            //                 });

            // // Query in arrondissements
            // $arrQuery = DB::table('communes')->whereExists(function($query) use ($search) {
            //                 $query->select()
            //                     ->from('arrondissements')
            //                     ->where('lib_arr', 'like', "%{$search}%");
            //             })
            //             ->join('arrondissements', function($join) {
            //                     $join->on('communes.id', '=', 'arrondissements.commune_id')
            //                         ->join('areas', 'arrondissements.id', '=', 'areas.arrondissement_id');
            //                 });

            //Query in areas and union prevs queries
            $zones = DB::table('areas')
                    ->where('lib_area', 'like', '%'.$search.'%')

                    ->join('arrondissements', function($join) {
                        $join->on('arrondissements.id', '=', 'areas.arrondissement_id')
                            ->join('communes', 'communes.id', '=', 'arrondissements.commune_id');
                    })
                    // ->unionAll($comQuery)
                    // ->unionAll($arrQuery)
                    ->get();
        } else {
            $zones = new Collection([]);
        }


        return Inertia::render('Dashboard/Index', [
            'filters' => Request::all('search'),
            'zones' => $zones,
        ]);
    }

    public function queryResult(Area $area)
    {
        return Inertia::render('Dashboard/Search', [
            'area' => [
                'id' => $area->id,
                'lib_area' => $area->lib_area,
                'maintenances' => Issue::all(),
                'agencies' => $area->agencies()->get(),
            ],
        ]);
    }
}
