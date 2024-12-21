<?php


namespace App\Services\User\Role;

use App\Models\Role;
use Carbon\Carbon;

class ShowService
{

    /**
     * @param int $id
     * @return Role
     */
    public function handle(int $id): Role
    {
        $role = Role::query()->with('permissions:id,group,action')->findOrFail($id);

        return $role;
    }
}
