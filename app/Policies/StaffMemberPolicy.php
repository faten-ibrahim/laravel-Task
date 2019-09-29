<?php

namespace App\Policies;

use App\StaffMember;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StaffMemberPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any staff members.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyPermission(['staff-list', 'staff-delete', 'staff-edit', 'staff-create']);
    }

    /**
     * Determine whether the user can view the staff member.
     *
     * @param  \App\User  $user
     * @param  \App\StaffMember  $staffMember
     * @return mixed
     */
    public function view(User $user, StaffMember $staff)
    {
        //
    }

    /**
     * Determine whether the user can create staff members.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAnyPermission(['staff-create','staff-delete','staff-edit']);
    }

    /**
     * Determine whether the user can update the staff member.
     *
     * @param  \App\User  $user
     * @param  \App\StaffMember  $staffMember
     * @return mixed
     */
    public function update(User $user, StaffMember $staff)
    {
        return $user->hasAnyPermission(['staff-delete','staff-edit']);
    }

    /**
     * Determine whether the user can delete the staff member.
     *
     * @param  \App\User  $user
     * @param  \App\StaffMember  $staffMember
     * @return mixed
     */
    public function delete(User $user, StaffMember $staff)
    {
        return $user->hasAnyPermission(['staff-delete','staff-edit']);
    }

    public function active(User $user, StaffMember $staff){
        return $user->hasPermissionTo('staff-active');
    }

    /**
     * Determine whether the user can restore the staff member.
     *
     * @param  \App\User  $user
     * @param  \App\StaffMember  $staffMember
     * @return mixed
     */
    public function restore(User $user, StaffMember $staffMember)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the staff member.
     *
     * @param  \App\User  $user
     * @param  \App\StaffMember  $staffMember
     * @return mixed
     */
    public function forceDelete(User $user, StaffMember $staffMember)
    {
        //
    }
}
