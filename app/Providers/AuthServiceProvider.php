<?php

namespace App\Providers;

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
    }
}
