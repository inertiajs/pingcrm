<?php

namespace App\Http\Api\Controllers;

use App\Models\Education;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class EducationsController extends Controller
{
    public function __construct()
    {
        auth()->loginUsingId(1);
    }

    public function index()
    {
        return [
            'filters' => Request::all('search', 'trashed'),
            'educations' => Auth::user()->account->educations()
                ->orderBy('title')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($education) {
                    return [
                        'id' => $education->id,
                        'title' => $education->title,
                        'name'=>$education->name,
                        'email'=>$education->email,
                        'phone' => $education->phone,
                        'school'=>$education->school,
                        'college'=>$education->college,
                        'higher_education'=>$education->higher_education,
                        'percentage'=>$education->percentage,
                    ];
                }),
        ];
    }

   

    public function store()
    {
        $education=Auth::user()->account->educations()->create(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'title' => ['required', 'max:100'],
                'name' => ['nullable', 'max:50'],
                'email' => ['nullable', 'max:50','email'],
                'phone' => ['nullable', 'max:50'],
                'school' => ['nullable', 'max:50'],
                'college' => ['nullable', 'max:50'],
                'higher_education'=> ['nullable', 'max:50'],
                'percentage' => ['nullable', 'max:50'],
                 
            ])
        );
        
        return $education->refresh();
    }

    public function show(Education $education)
    {
        return $education;
    }

    public function edit(Education $education)
    {
        return Inertia::render('Educations/Edit', [
            'education' => [
                'id' => $education->id,
                'title' => $education->title,
                'name'=>$education->name,
                'email'=>$education->email,
                'phone'=> $education->phone,
                'school'=>$education->school,
                'college'=>$education->college,
                'higher_education'=>$education->higher_education,
                'percentage'=>$education->percentage,
               // 'contacts' => $education->contacts()->orderByName()->get()->map->only('id', 'name', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Education $education)
    {
        $education->update(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'title' => ['required', 'max:100'],
                'name' => ['nullable', 'max:50'],
                'email' => ['nullable', 'max:50','email'],
                'phone' => ['nullable', 'max:50'],
                'school' => ['nullable', 'max:50'],
                'college' => ['nullable', 'max:50'],
                'higher_education'=> ['nullable', 'max:50'],
                'percentage' => ['nullable', 'max:50'],
               
            ])
        );

        return $education;
    }

    public function destroy(Education $education)
    {
        $education->delete();

        return response()->json(['success' =>'Education deleted.']);
    }

    public function restore(Education $education)
    {
        $education->restore();

        return response()->json(['success' =>'Education restored.']);
    }
}

