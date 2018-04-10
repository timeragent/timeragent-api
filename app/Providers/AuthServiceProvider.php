<?php

namespace App\Providers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest(
            'api',
            function (\Request $request) {
                if ($request->input('api_token')) {
                    return User::where('api_token', $request->input('api_token'))
                               ->first();
                }
            }
        );

        // Verified user can create organization
        Gate::define(
            'create_organization',
            function (User $user) {
                return $user->verified;
            }
        );

        // Organization owner can update his organization
        Gate::define(
            'update_organization',
            function (User $user, Organization $organization) {
                return $user->verified &&
                       (bool)$organization->owners()
                                          ->whereUuid($user->uuid)
                                          ->count();
            }
        );

        // User can update his profile
        Gate::define(
            'update_user', function (User $user, User $targetUser) {
            return $targetUser->uuid === $user->uuid;
        }
        );

        Passport::tokensCan(
            [
                'admin'                => 'Admin user scope',
                'basic'                => 'Basic user scope',
                'users'                => 'Users scope',
                'users:list'           => 'Users scope',
                'users:read'           => 'Users scope for reading records',
                'users:write'          => 'Users scope for writing records',
                'users:create'         => 'Users scope for creating records',
                'users:delete'         => 'Users scope for deleting records',
                'organizations:create' => 'Users scope for creating organizations',
            ]
        );
        // Register all policies here
        // Gate::policy(User::class, UserPolicy::class);
    }
}
