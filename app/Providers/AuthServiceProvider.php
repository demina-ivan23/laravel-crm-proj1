<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Enums\UserApiAccessLevelEnum;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
            $this->registerPolicies();
        
            Gate::define('access_api_source', function ($user, $requestMethod) {
                switch ($user->api_access_level) {
                    case UserApiAccessLevelEnum::FULL_ACCESS->name:
                        return true; 
                    case UserApiAccessLevelEnum::READ_WRITE->name:
                        return in_array($requestMethod, ['POST', 'GET']);
                    case UserApiAccessLevelEnum::READ_ONLY->name:
                        return $requestMethod === "GET";
                    default:
                        return false; 
                }
            });
    }
}
