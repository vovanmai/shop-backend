<?php


namespace App\Http\Controllers\Admin\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only([
            'email',
            'password',
        ]);

        $admin = Admin::where('email', $credentials['email'])->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            $token = $admin->createToken('Admin Access Token', ['admin'])->accessToken;

            return response()->success([
                'admin' => $admin,
                'access_token' => $token,
            ]);
        }

        return response()->error('Thông tin đăng nhập không đúng.', [], 400);
    }

    public function logout()
    {
        $user = auth()->user();

        $user->token()->revoke();

        return response()->success();
    }
}
