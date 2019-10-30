<?php

namespace App\Providers;

use App\City;
use App\Event;
use App\File;
use App\Folder;
use App\Job;
use App\News;
use App\Policies\CityPolicy;
use App\Policies\EventPolicy;
use App\Policies\FilePolicy;
use App\Policies\FolderPolicy;
use App\Policies\JobPolicy;
use App\Policies\NewsPolicy;
use App\Policies\RolePolicy;
use App\Policies\StaffMemberPolicy;
use App\Policies\VisitorPolicy;
use App\StaffMember;
use App\Visitor;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Role::class => RolePolicy::class,
        Job::class => JobPolicy::class,
        City::class=>CityPolicy::class,
        StaffMember::class => StaffMemberPolicy::class,
        Event::class => EventPolicy::class,
        News::class => NewsPolicy::class,
        Visitor::class=>VisitorPolicy::class,
        Folder::class=>FolderPolicy::class,
        File::class=>FilePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Admin') ? true : null;
        });
    }
}
