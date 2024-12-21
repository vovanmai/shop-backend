<?php


namespace App\Services\User\Permission;

use App\Models\Permission;
use Illuminate\Support\Collection;

class IndexService
{

    /**
     * @param array $data
     * @return Collection
     */
    public function handle(array $data)
    {
        $query = Permission::query();

        if (filled($data['sort'] ?? null) && filled($data['order'] ?? null)) {
            $query->orderBy($data['sort'], $data['order']);
        } else {
            $query->orderBy('id', 'ASC');
        }

        return $query->get(['id', 'group', 'action']);
    }
}
