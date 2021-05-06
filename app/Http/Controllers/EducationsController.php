<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class EducationsController extends Controller
{
    public function index()
    {
        return Inertia::render('Educations/Index', [
            'filters' => Request::all('search', 'trashed'),
            'educations' => Auth::user()->account->educations()
                ->orderBy('name')
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
        ]);
    }

    public function create()
    {
        return Inertia::render('Educations/Create');
    }

    public function store()
    {
        Auth::user()->account->educations()->create(
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

        return Redirect::route('educations')->with('success', 'Educations created.');
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

        return Redirect::back()->with('success', 'Education updated.');
    }

    public function destroy(Education $education)
    {
        $education->delete();

        return Redirect::back()->with('success', 'Education deleted.');
    }

    public function restore(Education $education)
    {
        $education->restore();

        return Redirect::back()->with('success', 'Education restored.');
    }
}
