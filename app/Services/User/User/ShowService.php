<?php


namespace App\Services\User\User;

use App\Models\Role;
use App\Models\User;

class ShowService
{

    /**
     * @param int $id
     * @return Role
     */
    public function handle(int $id): User
    {
        $user = User::query()->with([
            'role:id,name',
            'avatar:id,byte_size,filename,extension,content_type,path,uploadable_id'
        ])->findOrFail($id);

        return $user;
    }
}
