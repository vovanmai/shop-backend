<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\User\StoreRequest;
use App\Http\Requests\User\User\UpdateRequest;
use App\Services\User\User\DestroyService;
use App\Services\User\User\IndexService;
use App\Services\User\User\ShowService;
use App\Services\User\User\StoreService;
use App\Services\User\User\UpdateService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->only([
            'name',
            'email',
            'per_page',
            'sort',
            'order',
            'created_at_from',
            'created_at_to',
            'updated_at_from',
            'updated_at_to',
        ]);

        $result = resolve(IndexService::class)->handle($data);

        return response()->success($result);
    }

    public function show(int $id)
    {
        $result = resolve(ShowService::class)->handle($id);

        return response()->success($result);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $result = resolve(StoreService::class)->handle($data);

        return response()->success($result->id);
    }

    public function update(UpdateRequest $request, int $id)
    {
        $data = $request->validated();

        resolve(UpdateService::class)->handle($id, $data);

        return response()->success();
    }

    public function destroy(int $id)
    {
        resolve(DestroyService::class)->handle($id);
        return response()->success();
    }
}
