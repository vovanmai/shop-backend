<?php


namespace App\Services\User\User;

use App\Models\User;
use Carbon\Carbon;

class IndexService
{
    /**
     * @param array $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function handle(array $data)
    {
        $query = User::query()
            ->with('role:id,name')
            ->where('company_id', auth()->user()->company_id);

        if (filled($data['name'] ?? null)) {
            $query->where('name', 'like', "%{$data['name']}%");
        }

        if (filled($data['email'] ?? null)) {
            $query->where('email', 'like', "%{$data['email']}%");
        }

        if (filled($data['sort'] ?? null) && filled($data['order'] ?? null)) {
            $query->orderBy($data['sort'], $data['order']);
        } else {
            $query->orderBy('updated_at', 'DESC')
                ->orderBy('id', 'ASC');
        }

        if (filled($data['created_at_from'] ?? null)) {
            $query->where('created_at', '>=', Carbon::parse($data['created_at_from'])->format('Y-m-d H:i:s'));
        }

        if (filled($data['created_at_to'] ?? null)) {
            $query->where('created_at', '<=', Carbon::parse($data['created_at_to'])->format('Y-m-d H:i:s'));
        }

        if (filled($data['updated_at_from'] ?? null)) {
            $query->where('updated_at', '>=', Carbon::parse($data['updated_at_from'])->format('Y-m-d H:i:s'));
        }

        if (filled($data['updated_at_to'] ?? null)) {
            $query->where('updated_at', '<=', Carbon::parse($data['updated_at_to'])->format('Y-m-d H:i:s'));
        }

        return $query->paginate($data['per_page'] ?? 10);
    }
}
