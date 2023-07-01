<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => function () use ($request) {
                $user = $request->user();
                $userArray = null;

                if ($user) {
                    $userArray = $user->only('id', 'name', 'email');

                    // If the user is logged in, load their profile
                    $userArray['association'] = $user->association
                        ? $user->association->only('image', 'name') // replace with your actual attribute names
                        : null;
                    $userArray['roles'] = $user->roles->pluck('name');
                }

                return [
                    'user' => $userArray,
                ];
            },
            'flash' => [
                'message' => session('message')
            ]
        ]);
    }
}
