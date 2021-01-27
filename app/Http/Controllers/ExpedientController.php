<?php

namespace App\Http\Controllers;

use App\Models\Expedient;
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
                    ->filter(Request::only('search', 'trashed'))
                    ->ownerOrFollowerUser(Auth::user())
                    ->paginate(10)
                    ->transform(function ($expedient) {
                        return [
                            'id' => $expedient->id,
                            'name' => $expedient->name,
                            'deleted_at' => $expedient->deleted_at,
                            'template' => $expedient->template->name,
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
                'documents' => $expedient->requirements->map(function ($R) {
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
            'templates' => Template::all()
                ->transform(function ($template) {
                    return [
                        'id' => $template->id,
                        'name' => $template->name,
                        'requirements' => $template->requirements
                    ];
                }),
            'users' => User::all()
                ->transform(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'photo' => $user->photo,
                    ];
                }),
        ]);
    }

    public function store()
    {
        Request::validate([
            'name' => ['required', 'max:100', Rule::unique('expedients')],
            'requirements' => ['required', 'array'],
            'users_followers' => ['required', 'array'],
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
                                'title' => $D->requirement->name,
                                'description' => $D->requirement->description,
                            ];
                        }),
                    'documents_count' => $S->documents->where('expedient_id', $expedient->id)->count()
                ];
            })
        ]);
    }

    public function update(Expedient $expedient)
    {
        $expedient->update(
            Request::validate([
                'name' => ['required', 'max:100', Rule::unique('expedients')],
                'users_followers' => ['required', 'array'],
                'active' => ['required'],
            ])
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
}
