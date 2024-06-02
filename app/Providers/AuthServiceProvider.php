<?php

namespace App\Providers;

use App\Models\Permission;
use App\Policies\{
    OrderPolicy,
    ProductPolicy,
    ProspectPolicy,
    OrderStatusPolicy,
    ProspectStatePolicy,
    RolePolicy,
    UserPolicy,
};
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        OrderPolicy::class,
        OrderStatusPolicy::class,
        ProductPolicy::class,
        ProspectPolicy::class,
        ProspectStatePolicy::class,
        RolePolicy::class,
        UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('view-charts', function () {
            return auth()->check() && auth()->user()->role->permissions->contains(Permission::where('title', 'order-chart-read-web')->first()->id);
        });
        Gate::define('states-dashboard', function () {
            return auth()->check() && auth()->user()->role->permissions->contains(Permission::where('title', 'states-dashboard')->first()->id);
        });
        Gate::define('users-roles-dashboard', function () {
            return auth()->check() && auth()->user()->role->permissions->contains(Permission::where('title', 'users-roles-dashboard')->first()->id);
        });
        Gate::define('prospects-products-orders-dashboard', function() {
            return auth()->check() && auth()->user()->role->permissions->contains(Permission::where('title', 'prospects-products-orders-dashboard')->first()->id);
         });
    }
}
