<?php


namespace App\Services\User\Role;

use App\Models\Role;

class StoreService
{
    /**
     * @param array $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function handle(array $data)
    {
        $role = Role::create([
            'name' => $data['name'],
            'company_id' => auth()->user()->company_id,
            'type' => Role::TYPE_CUSTOMIZE
        ]);

        $role->permissions()->attach($data['permission_ids']);

        return $role;
    }
}
