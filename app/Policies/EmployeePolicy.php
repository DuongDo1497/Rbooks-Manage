<?php

namespace App\Policies;

use RBooks\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function list(User $user)
    {
        $employee_index = $user->roles()->whereIn('display_name', ['admin'])->count();
        if($employee_index > 0) {
            return true;
        }
        return false;
    }
}
