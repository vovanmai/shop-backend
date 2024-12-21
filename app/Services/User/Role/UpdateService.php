<?php


namespace App\Services\User\Role;

use App\Exceptions\BadRequestException;
use App\Models\Role;

class UpdateService
{

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function handle(int $id, array $data)
    {
        $role = Role::query()->findOrFail($id);

        if ($role->type === Role::TYPE_DEFAULT) {
            throw new BadRequestException('Bạn không thể chỉnh sửa quyền mặc định.');
        }

        Role::where('id', $role->id)
            ->update([
                'name' => $data['name'],
            ]);

        $role->permissions()->sync($data['permission_ids'] ?? []);
    }
}
