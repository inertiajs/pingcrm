<?php

namespace App\Http\Controllers;

use App\Models\Expedient;
use App\Models\Requirement;
use App\Models\Status;
use App\Models\Template;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ExpedientController extends Controller
{
    public function index()
    {
        return
            Inertia::render('Expedients/Index', [
                'filters' => Request::all('search', 'trashed', 'page'),
                'expedients' => Expedient::orderByName()
                    ->filter(Request::only('search', 'trashed', 'folio'))
                    ->ownerOrFollowerUser(Auth::user())
                    ->paginate(10)
                    ->transform(function ($expedient) {
                        return [
                            'id' => $expedient->id,
                            'name' => $expedient->name,
                            'deleted_at' => $expedient->deleted_at,
                            'template' => $expedient->template()->withTrashed()->get('name')->pluck('name')->join(''),
                            'owner_user' => $expedient->owner_user->only('id', 'name', 'email'),
                            'follower_users_count' => $expedient->follower_users()->count(),
                            'requirements_count' => $expedient->requirements()->count(),
                            'created_at' => $expedient->created_at,
                        ];
                    }),
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expedient  $expedient
     * @return \Illuminate\Http\Response
     */
    public function show(Expedient $expedient)
    {
        return Inertia::render('Expedients/Show', [
            'expedient' => [
                'id' => $expedient->id,
                'name' => $expedient->name,
                'documents' => $expedient->requirements()->withTrashed()->get()->map(function ($R) {
                    return [
                        'id' => $R->document->id,
                        'title' => $R->name,
                        'description' => $R->description,
                        'status' => $R->document->status->key,
                        'commentary' => $R->document->commentary,
                        'until_valid' => $R->document->until_valid,
                        'files_count' => $R->document->files()->count()
                    ];
                }),
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Expedients/Create', [
            'templates' => Template::orderByName()->get()->map->only('id', 'name', 'requirements'),
            'users' => User::orderByName()->get()->map->only('id', 'name', 'email')
        ]);
    }

    public function store()
    {
        Request::validate([
            'name' => ['required', 'max:100', Rule::unique('expedients')],
            'requirements' => ['array'],
            'users_followers' => ['array'],
            'owner_user' => ['required'],
            'template' => ['required'],
            'active' => ['required'],

        ]);

        DB::beginTransaction();
        try {
            $status = Status::where('key', Status::STATUS_KEY_PENDING)->first();
            $expedient = Expedient::create(
                [
                    'name' => Request::get('name'),
                    'active' => Request::get('active'),
                    'owner_user_id' => Request::get('owner_user'),
                    'template_id' => Request::get('template'),
                    'user_id' => Auth::user()->id,
                ]
            );
            if ($requirements = Request::get('requirements', []))
                foreach ($requirements as $requirement_id) {
                    $expedient->requirements()->attach(
                        $requirement_id,
                        ['status_id' => $status->id]
                    );
                }
            $expedient->follower_users()->syncWithoutDetaching(
                Request::input('users_followers')
            );
        } catch (Exception $e) {
            DB::rollback();
            return Redirect::back()->with('error', 'ERROR AL CREAR EXPEDIENTE.');
        }
        DB::commit();
        return Redirect::route('expedients')->with('success', 'Expedient created.');
    }

    public function documents(Expedient $expedient)
    {
        return Inertia::render('Expedients/Documents', [
            'statuses' => Status::all('text', 'key'),
            'expedient' => [
                'id' => $expedient->id,
                'name' => $expedient->name,
                'deleted_at' => $expedient->deleted_at,
                "active" => $expedient->active,
                "template" => $expedient->template->id,
                "owner_use" => $expedient->owner_user,
                "users_follower" => $expedient->follower_users,
            ],
            'folders' => Status::all()->map(function ($S) use ($expedient) {
                return [
                    'status_text' => $S->text,
                    'documents' => $S->documents
                        ->where('expedient_id', $expedient->id)
                        ->map(function ($D) {
                            return [
                                'id' => $D->id,
                                'files' => $D->files,
                                'until_valid' => $D->until_valid,
                                'commentary' => $D->commentary,
                                'status_key' => $D->status->key,
                                'title' => $D->requirement()->withTrashed()->get('name')->pluck('name')->join(''),
                                'description' => $D->requirement()->withTrashed()->get('description')->pluck('description')->join(''),
                            ];
                        }),
                    'documents_count' => $S->documents->where('expedient_id', $expedient->id)->count()
                ];
            }),
            'requirements' => Requirement::whereNotIn('id', $expedient->requirements->pluck('id'))->get(['id', 'name'])
        ]);
    }

    public function edit(Expedient $expedient)
    {
        return Inertia::render('Expedients/Edit', [
            'expedient' => [
                'id' => $expedient->id,
                'name' => $expedient->name,
                'active' => $expedient->active,
                'deleted_at' => $expedient->deleted_at,
                'template' => $expedient->template->only('id', 'name'),
                'requirements' => $expedient->requirements,
                'owner_user' => $expedient->owner_user->only('id', 'name', 'email'),
                'users_followers' => $expedient->follower_users()->orderByName()->get()->map->only('id', 'name', 'email'),
            ],
            'templates' => Template::orderByName()->get()->map->only('id', 'name', 'requirements'),
            'users' => User::orderByName()->get()->map->only('id', 'name', 'email')
        ]);
    }

    public function update(Expedient $expedient)
    {
        Request::validate([
            'name' => ['required', 'max:100', Rule::unique('expedients')->ignore($expedient->id)],
            'users_followers' => ['array'],
            'active' => ['required'],
        ]);
        $expedient->update(Request::only('name', 'active'));
        $expedient->follower_users()->sync(
            Request::input('users_followers')
        );

        return Redirect::back()->with('success', 'Expedient updated.');
    }

    public function destroy(Expedient $expedient)
    {
        $expedient->delete();

        return Redirect::back()->with('success', 'Expedient deleted.');
    }

    public function restore(Expedient $expedient)
    {
        $expedient->restore();

        return Redirect::back()->with('success', 'Expedient restored.');
    }

    public function addRequirement(Expedient $expedient)
    {

        Request::validate([
            'requirement' => ['required'],
        ]);
        $status = Status::where('key', Status::STATUS_KEY_PENDING)->first();
        $expedient->requirements()->attach(
            Request::get('requirement'),
            ['status_id' => $status->id]
        );

        return Redirect::back()->with('success', 'Requisito Agregado');
    }
}
