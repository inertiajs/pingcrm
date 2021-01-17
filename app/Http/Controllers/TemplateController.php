<?php

namespace App\Http\Controllers;

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
                        ];
                    }),
            ]);
    }

    public function create()
    {
        return Inertia::render('Templates/Create');
    }

    public function store()
    {
        Template::create(
            Request::validate([
                'name' => ['required', 'max:100'],
            ])
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
        ]);
    }

    public function update(Template $template)
    {
        $template->update(
            Request::validate([
                'name' => ['required', 'max:100'],
            ])
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
