<?php


namespace App\Services\User\User;

use App\Exceptions\BadRequestException;
use App\Models\User;
use App\Services\Traits\FileTrait;
use Illuminate\Support\Facades\DB;

class UpdateService
{
    use FileTrait;

    /**
     * @param array $data
     * @return void
     */
    public function handle(int $id, array $data)
    {
        $user = User::query()->findOrFail($id);
        if ($user->id === auth()->id()) {
            throw new BadRequestException('Bạn không thể cập tài khoản chính bạn.');
        }

        DB::transaction(function () use ($user, $data) {
            $dataUpdate = [
                'name' => $data['name'],
                'email' => $data['email'],
                'role_id' => $data['role_id'],
            ];

            if (filled($data['password'] ?? null)) {
                $dataUpdate['password'] = bcrypt($data['password']);
            }

            if (!empty($data['avatar_id'])) {
                if ($user->avatar) {
                    $this->deleteFiles([$user->avatar->id]);
                }

                $this->updateFiles($user, [$data['avatar_id']], 'avatar');
            }

            User::query()->where('id', $user->id)
                ->update($dataUpdate);
        });
    }
}
