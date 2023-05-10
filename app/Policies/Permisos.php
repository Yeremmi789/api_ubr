<?php

namespace App\Policies;

use App\Models\Pacientes;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class Permisos
{
    use HandlesAuthorization;

    public function before($user, $ability){
        if($user->isGranted(User::ROLE_ADMIN)){
            return true;
        }
    }

    public function viewAny(User $user)
    {
        //
        return $user->isGranted(User::ROLE_USER);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pacientes $Pacientes)
    {
        //
        return $user->isGranted(User::ROLE_USER);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
        return $user->isGranted(User::ROLE_USER);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pacientes $Pacientes)
    {
        //
        return $user->isGranted(User::ROLE_ADMIN);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pacientes $Pacientes)
    {
        //
        return $user->isGranted(User::ROLE_ADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pacientes $Pacientes)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pacientes $Pacientes)
    {
        //
    }
}
