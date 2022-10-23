<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Area;
use App\Models\Dependencia;
use App\Models\Directorio;
use App\Models\issue;
use App\Models\Gerencia;
use App\Models\Role;
use App\Models\User;
use App\Policies\DependenciaPolicy;
use App\Policies\DirectorioPolicy;
use App\Policies\IssuePolicy;
use App\Policies\GerenciaPolicy;
use App\Policies\UserPolicy;
use App\Policies\AreaPolicy;
use App\Policies\RolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Area::class => AreaPolicy::class,
        Dependencia::class => DependenciaPolicy::class,
        Directorio::class => DirectorioPolicy::class,
        Gerencia::class => GerenciaPolicy::class,
        Issue::class => IssuePolicy::class,
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
