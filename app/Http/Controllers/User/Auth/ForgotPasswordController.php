<?php


namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function sendResetLink(ForgotPasswordRequest $request)
    {
        $data = $request->validated();

        $user = User::query()->where('company_id', $data['company_id'])
            ->where('email', $data['email'])
            ->firstOrFail(['email', 'id']);

        $token =  DB::table('password_reset_tokens')->where([
            ['user_id', $user->id]
        ]);

        if ($token->exists()) {
            $token->delete();
        }

        $valueToken = Str::uuid()->toString();

        DB::table('password_reset_tokens')
            ->insert(
                [
                    'user_id' => $user->id,
                    'token' => $valueToken,
                    'created_at' => now()
                ]
            );

        $user->sendPasswordResetNotification($valueToken);
    }
}
