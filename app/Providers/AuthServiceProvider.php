<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Enums\UserApiAccessLevelEnum;
use App\Policies\OrderPolicy;
use App\Policies\OrderStatusPolicy;
use App\Policies\ProductPolicy;
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
        
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
            $this->registerPolicies();
    }
}
