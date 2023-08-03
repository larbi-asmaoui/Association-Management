<?php

namespace App\Http\Middleware;

use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
                $association = null;
                if ($user) {
                    $userArray = $user->only('id', 'name', 'email');
                    $userArray['permissions'] = $user->permissions->pluck('name');
                    $association = Association::first();
                    if ($association) {
                        $association = $association->only('image', 'name', 'date_creation');
                    }
                }

                return [
                    'user' => $userArray,
                    'association' => $association
                ];
            },
            'flash' => [
                'message' => session('message')
            ]
        ]);
    }
}
