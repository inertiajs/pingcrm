<?php

namespace App\Http\Controllers;

use App\Models\Requirement;
use App\Models\Template;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class TemplateController extends Controller
{
    public function index()
    {
        return
            Inertia::render('Templates/Index', [
                'filters' => Request::all('search', 'trashed'),
                'templates' => Template::orderByName()
                    ->filter(Request::only('search', 'trashed'))
                    ->paginate()
                    ->transform(function ($template) {
                        return [
                            'id' => $template->id,
                            'name' => $template->name,
                            'deleted_at' => $template->deleted_at,
                            'requirements_count' => $template->requirements()->count()
                        ];
                    }),
            ]);
    }

    public function create()
    {
        return Inertia::render('Templates/Create', [
            'requirements' => Requirement::all('id', 'name')
        ]);
    }

    public function store()
    {
        Request::validate([
            'name' => ['required', 'max:100'],
            'requirements' => ['required', 'array']
        ]);

        $template = Template::create(
            Request::only('name')
        );

        $template->requirements()->syncWithoutDetaching(
            Request::input('requirements')
        );

        return Redirect::route('templates')->with('success', 'Template created.');
    }

    public function edit(Template $template)
    {
        return Inertia::render('Templates/Edit', [
            'template' => [
                'id' => $template->id,
                'name' => $template->name,
                'deleted_at' => $template->deleted_at,
            ],
            'requirements' => Requirement::all('id', 'name'),
            'items' => $template->requirements()->orderByName()->get()->map->only('id', 'name'),
        ]);
    }

    public function update(Template $template)
    {

        Request::validate([
            'name' => ['required', 'max:100'],
            'requirements' => ['required', 'array']
        ]);

        $template->update(
            Request::only('name')
        );

        $template->requirements()->sync(
            Request::input('requirements')
        );

        return Redirect::back()->with('success', 'Template updated.');
    }

    public function destroy(Template $template)
    {
        $template->delete();

        return Redirect::back()->with('success', 'Template deleted.');
    }

    public function restore(Template $template)
    {
        $template->restore();

        return Redirect::back()->with('success', 'Template restored.');
    }
}
