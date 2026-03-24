<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Order;
use App\Models\Stock;
use App\Models\PurchaseOrders;
use App\Models\DailyExpense;
use App\Models\DailyConsumption;
use App\Policies\OrderPolicy;
use App\Policies\StockPolicy;
use App\Policies\PurchaseOrdersPolicy;
use App\Policies\DailyExpensePolicy;
use App\Policies\DailyConsumptionPolicy;
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
        Order::class => OrderPolicy::class,
        Stock::class => StockPolicy::class,
        PurchaseOrders::class => PurchaseOrdersPolicy::class,
        DailyExpense::class => DailyExpensePolicy::class,
        DailyConsumption::class => DailyConsumptionPolicy::class,
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
