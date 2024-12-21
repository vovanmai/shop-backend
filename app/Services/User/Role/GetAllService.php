<?php


namespace App\Services\User\Role;

use App\Models\Role;
use Illuminate\Support\Collection;

class GetAllService
{
    /**
     * @param array $data
     * @return Collection
     */
    public function handle()
    {
        $query = Role::query();

        return $query->orderBy('id', 'ASC')->get();
    }
}
