<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Role\StoreRequest;
use App\Http\Requests\User\Role\UpdateRequest;
use App\Services\User\Role\DestroyService;
use App\Services\User\Role\GetAllService;
use App\Services\User\Role\IndexService;
use App\Services\User\Role\ShowService;
use App\Services\User\Role\StoreService;
use App\Services\User\Role\UpdateService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->only([
            'name',
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

    public function getAll()
    {
        $result = resolve(GetAllService::class)->handle();

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

        return response()->success($result);
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
