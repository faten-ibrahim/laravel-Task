<?php

namespace App\Policies;

use App\User;
use App\Visitor;
use Illuminate\Auth\Access\HandlesAuthorization;

class VisitorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any visitors.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyPermission(['visitor-list', 'visitor-delete', 'visitor-edit', 'visitor-create']);
    }

    /**
     * Determine whether the user can view the visitor.
     *
     * @param  \App\User  $user
     * @param  \App\Visitor  $visitor
     * @return mixed
     */
    public function view(User $user, Visitor $visitor)
    {
        //
    }

    /**
     * Determine whether the user can create visitors.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAnyPermission(['visitor-delete', 'visitor-edit', 'visitor-create']);
    }

    /**
     * Determine whether the user can update the visitor.
     *
     * @param  \App\User  $user
     * @param  \App\Visitor  $visitor
     * @return mixed
     */
    public function update(User $user, Visitor $visitor)
    {
        return $user->hasAnyPermission(['visitor-delete', 'visitor-edit']);
    }

    /**
     * Determine whether the user can delete the visitor.
     *
     * @param  \App\User  $user
     * @param  \App\Visitor  $visitor
     * @return mixed
     */
    public function delete(User $user, Visitor $visitor)
    {
        return $user->hasAnyPermission(['visitor-delete', 'visitor-edit']);
    }


    public function active(User $user, Visitor $visitor){
        return $user->hasPermissionTo('visitor-active');
    }


    /**
     * Determine whether the user can restore the visitor.
     *
     * @param  \App\User  $user
     * @param  \App\Visitor  $visitor
     * @return mixed
     */
    public function restore(User $user, Visitor $visitor)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the visitor.
     *
     * @param  \App\User  $user
     * @param  \App\Visitor  $visitor
     * @return mixed
     */
    public function forceDelete(User $user, Visitor $visitor)
    {
        //
    }
}
