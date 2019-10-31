<?php

namespace App\Policies;

use App\File;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any files.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {

        //
    }

    /**
     * Determine whether the user can view the file.
     *
     * @param  \App\User  $user
     * @param  \App\File  $file
     * @return mixed
     */
    public function view(User $user, File $file)
    {
         return ($user->staff_member->folders->contains($file->fileable()->first()) && $user->staff_member->hasPermissionTo('CrudFolder'));
    }

    /**
     * Determine whether the user can create files.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->staff_member->hasPermissionTo('CrudFolder');
        // return ($user->staff_member->folders->contains($file->fileable()->first()) && $user->staff_member->hasPermissionTo('CrudFolder'));
    }

    /**
     * Determine whether the user can update the file.
     *
     * @param  \App\User  $user
     * @param  \App\File  $file
     * @return mixed
     */
    public function update(User $user, File $file)
    {

        return ($user->staff_member->folders->contains($file->fileable()->first()) && $user->staff_member->hasPermissionTo('CrudFolder'));
    }

    /**
     * Determine whether the user can delete the file.
     *
     * @param  \App\User  $user
     * @param  \App\File  $file
     * @return mixed
     */
    public function delete(User $user, File $file)
    {
         return ($user->staff_member->folders->contains($file->fileable()->first()) && $user->staff_member->hasPermissionTo('CrudFolder'));
    }

    /**
     * Determine whether the user can restore the file.
     *
     * @param  \App\User  $user
     * @param  \App\File  $file
     * @return mixed
     */
    public function restore(User $user, File $file)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the file.
     *
     * @param  \App\User  $user
     * @param  \App\File  $file
     * @return mixed
     */
    public function forceDelete(User $user, File $file)
    {
        //
    }
}
