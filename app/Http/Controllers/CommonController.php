<?php


namespace App\Http\Controllers;

use App\Http\Requests\Common\CreateUploadRequest;
use App\Services\Common\CreateUploadService;

class CommonController extends Controller
{
    public function createUpload(CreateUploadRequest $request)
    {
        $data = $request->validated();

        $result = resolve(CreateUploadService::class)->handle($data);

        return response()->success($result);
    }
}
