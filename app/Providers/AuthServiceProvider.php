<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin_only',function ($user){
           return $user->hasRole('admin');
        });


        Gate::define('stockeeper',function ($user){
           return $user->hasAnyRoles(['admin','stockeeper']);
        });


        Gate::define('cashier',function ($user){
           return $user->hasAnyRoles(['admin','user']);
        });
    }
}
