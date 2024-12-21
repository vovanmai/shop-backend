<?php


namespace App\Http\Controllers\User\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\VerifyEmailRequest;
use App\Mail\OrderShipped;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = User::join('companies', 'companies.id', '=', 'users.company_id')
            ->where('companies.id', $credentials['company_id'])
            ->where('users.email', $credentials['email'])
            ->first([
                'companies.id as company_id',
                'users.id',
                'users.name',
                'users.status',
                'users.email',
                'users.password',
                'users.created_at',
            ]);

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = $user->createToken('User Access Token', ['user'])->accessToken;

            return response()->success([
                'user' => $user,
                'access_token' => $token,
            ]);
        }

//        if ($user) {
//            if ($user->company_status === Company::STATUS_REGISTER) {
//                return response()->error('Công ty chưa được duyệt. Vui lòng liên hệ quản trị hệ thống.', [], 403);
//            }
//
//            if ($user->company_status === Company::STATUS_BLOCKED) {
//                return response()->error('Công ty đã bị vô hiệu . Vui lòng liên hệ quản trị hệ thống.', [], 403);
//            }
//
//
//            if ($user->status === Admin::STATUS_INACTIVE) {
//                return response()->error('Tài khoản đã bị vô hiệu . Vui lòng liên hệ quản trị viên của công .', [], 403);
//            }
//
//
//            if (Hash::check($credentials['password'], $user->password)) {
//                $tokenResult = $user->createToken(' access token', ['employee']);
//
//                return response()->success([
//                    'user' => $user,
//                    'access_token' => $tokenResult->accessToken,
//                    'token_type' => 'Bearer',
//                ]);
//            }
//        }

        return response()->error('Thông tin đăng nhập không đúng.', [], 400);
    }

    public function logout()
    {
        $user = auth()->user();

        $user->token()->revoke();

        return response()->success();
    }

    public function getProfile()
    {
        $user = auth()->user();

        $user->load([
            'role' => function ($query) {
                $query->select(['id', 'name'])->with('permissions:group,action');
            }
        ]);

        return response()->success($user);
    }

    public function getCompaniesByEmail(VerifyEmailRequest $request)
    {
        $data = $request->validated();

        $companies = Company::whereHas('users', function ($query) use ($data) {
            return $query->where('email', $data['email']);
        })->get(['id', 'name']);

        return response()->success($companies);
    }
}
