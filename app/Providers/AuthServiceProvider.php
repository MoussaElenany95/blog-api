<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Role;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
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
        //user permissions
        Gate::define('create-user',function(User $user){
            if($user->hasPermission('create-user')){
                return true;
            }
        });
        Gate::define('show-user',function(User $user){
            if($user->hasPermission('show-user')){
                return true;
            }
        });
        Gate::define('update-user',function(User $user,$updated){
            if($user->hasPermission('update-user')){
                return true;
            }else{
                return $user->id == $updated;
            }
        });
        Gate::define('delete-user',function(User $user){
            if($user->hasPermission('delete-user')){
                return true;
            }
        });

        //article permissions
        Gate::define('create-article',function(User $user){
            if($user->hasPermission('create-article')){
                return true;
            }
        });
        Gate::define('update-article',function(User $user,$updated){
            if($user->hasPermission('update-article')){
                return true;
            }else{
                return $user->id == $updated;
            }
        });
        Gate::define('delete-article',function(User $user){
            if($user->hasPermission('delete-article')){
                return true;
            }else{
                return $user->id == $updated;
            }
        });

        //tag permissions
        Gate::define('create-tag',function(User $user){
            if($user->hasPermission('create-tag')){
                return true;
            }
        });
        Gate::define('show-tag',function(User $user){
            if($user->hasPermission('show-tag')){
                return true;
            }
        });
        Gate::define('update-tag',function(User $user){
            if($user->hasPermission('update-tag')){
                return true;
            }
        });
        Gate::define('delete-tag',function(User $user){
            if($user->hasPermission('delete-tag')){
                return true;
            }
        });

        //roles access
        Gate::define('create-role',function(User $user){
            if($user->hasPermission('create-role')){
                return true;
            }
        });
        Gate::define('show-role',function(User $user){
           
            if($user->hasPermission('show-role')){
                return true;
            }
        });
        Gate::define('update-role',function(User $user){
            if($user->hasPermission('update-role')){
                return true;
            }
        });
        Gate::define('delete-role',function(User $user){
            if($user->hasPermission('delete-role')){
                return true;
            }
        });
        Gate::define('assign-role',function(User $user){
            if($user->hasPermission('assign-role')){
                return true;
            }
        });
        
        //permissions access
        Gate::define('create-permission',function(User $user){
            if($user->hasPermission('create-permission')){
                return true;
            }
        });
        Gate::define('show-permission',function(User $user){
           
            if($user->hasPermission('show-permission')){
                return true;
            }
        });
        Gate::define('update-permission',function(User $user){
            if($user->hasPermission('update-permission')){
                return true;
            }
        });
        Gate::define('delete-permission',function(User $user){
            if($user->hasPermission('delete-permission')){
                return true;
            }
        });
       
        

        //
    }
}
