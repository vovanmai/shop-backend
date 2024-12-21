<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\Permission\IndexService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->only([
            'sort',
            'order',
        ]);

        $result = resolve(IndexService::class)->handle($data);

        return response()->success($result);
    }
}
