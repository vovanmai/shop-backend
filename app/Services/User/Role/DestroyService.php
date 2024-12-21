<?php


namespace App\Services\User\Role;

use App\Exceptions\BadRequestException;
use App\Models\Role;
use App\Models\User;

class DestroyService
{

    /**
     * @param int $
     * @return void
     */
    public function handle(int $id)
    {
        $role = Role::query()->findOrFail($id);

        if ($role->type === Role::TYPE_DEFAULT) {
            throw new BadRequestException('Bạn không thể xoá quyền mặc định.');
        }

        $exists = User::query()->where('role_id', $role->id)->exists();

        if ($exists) {
            throw new BadRequestException('Quyền này đã được sử dụng.');
        }

        $role->delete();
    }
}
