<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
                // Then check, access_token created by the client_credentials grant is valid.
                // We need this checking because we could use either password grant or client_credentials grant.
                try {
                    app(CheckClientCredentials::class)->handle(
                        $request, function () {
                    }
                    );
                } catch (\Exception $e) {
                    return response()->json((['status' => 401, 'message' => 'Unauthorized']), 401);
                }
        }
    }
}
