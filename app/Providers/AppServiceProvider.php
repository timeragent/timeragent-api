<?php

namespace App\Providers;

use App\Models\Organization;
use App\Models\User;
use Dusterio\LumenPassport\LumenPassport;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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

    public function boot()
    {
        LumenPassport::routes($this->app);
        Relation::morphMap([
            User::MORPH_NAME         => User::class,
            Organization::MORPH_NAME => Organization::class,
        ]);
    }
}
