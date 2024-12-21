<?php


namespace App\Services\User\User;

use App\Models\User;
use App\Services\Traits\FileTrait;
use Illuminate\Support\Facades\DB;

class StoreService
{
    use FileTrait;

    /**
     * @param array $data
     * @return User
     */
    public function handle(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'company_id' => auth()->user()->company_id,
                'role_id' => $data['role_id'],
                'status' => User::STATUS_ACTIVE,
            ]);

            if (!empty($data['avatar_id'])) {
                $this->updateFiles($user, [$data['avatar_id']], 'avatar');
            }

            return $user;
        });
    }


}
