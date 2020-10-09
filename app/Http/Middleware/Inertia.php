<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Concerns\InertiaDefaults;
use Inertia\Middleware;

class Inertia extends Middleware
{
    use InertiaDefaults {
        share as defaultShare;
        version as defaultVersion;
    }

    /**
     * Determine the current Inertia asset version hash
     * used for automatic asset cache busting.
     *
     * @see https://inertiajs.com/asset-versioning
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version($request)
    {
        return md5_file(public_path('mix-manifest.json'));
    }

    /**
     * Defines the Inertia properties that automatically
     * shared as of default. Can be overwritten.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share($request)
    {
        return array_merge($this->defaultShare($request), [
            'auth' => function () {
                return [
                    'user' => Auth::user() ? [
                        'id' => Auth::user()->id,
                        'first_name' => Auth::user()->first_name,
                        'last_name' => Auth::user()->last_name,
                        'email' => Auth::user()->email,
                        'role' => Auth::user()->role,
                        'account' => [
                            'id' => Auth::user()->account->id,
                            'name' => Auth::user()->account->name,
                        ],
                    ] : null,
                ];
            },
            'flash' => function () {
                return [
                    'success' => Session::get('success'),
                    'error' => Session::get('error'),
                ];
            },
        ]);
    }
}
