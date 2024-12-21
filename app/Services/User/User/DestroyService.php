<?php


namespace App\Services\User\User;

use App\Exceptions\BadRequestException;
use App\Models\User;

class DestroyService
{

    /**
     * @param int $
     * @return void
     */
    public function handle(int $id)
    {
        $user = User::query()->findOrFail($id);

        if ($user->id === auth()->id()) {
            throw new BadRequestException('Bạn không thể cập tài khoản chính bạn.');
        }

        $user->delete();
    }
}
