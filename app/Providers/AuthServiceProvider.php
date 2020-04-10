<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;


use \App\User;
use \App\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(User $user)
    {
        $this->registerPolicies();

        // Super User
        Gate::before(function(User $user, $ability){
            if($user->isSuperUser()) return true;
        });
        
        // Is Mine
        Gate::define('mine', function(User $user, $object){
            return $user->id == $object->user->id;
        });
        
        // Access Control List
        $permission = new Permission();
        if(!Schema::hasTable($permission->getTable())) return;

        foreach(Permission::with('roles')->get() as $permission)
        {
            Gate::define($permission->name, function(User $user) use ($permission) {
                return $user->hasPermission($permission);
            });
        }
    }
}
