<?php
namespace App\Services\Traits;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

trait FileTrait
{

    /**
     * Update files.
     *
     * @param Model $model Model
     * @param array $fileIds
     * @param string $field Field
     *
     * @return boolean
     */
    public function updateFiles(Model $model, array $fileIds, string $field)
    {
        return Upload::whereIn('id', $fileIds)->update([
            'uploadable_type' => $model->getMorphClass(),
            'uploadable_id' => $model->id,
            'field' => $field
        ]);
    }

    /**
     * Delete files.
     *
     * @param array $fileIds Upload ids
     *
     * @return boolean
     */
    public function deleteFiles(array $fileIds)
    {
        $files = Upload::query()->whereIn('id', $fileIds)->get()->keyBy('id');

        foreach ($fileIds as $fileId) {
            $file = $files->get($fileId);

            Storage::disk('upload')->deleteDirectory($file['path']);

            $file->delete();
        }
    }
}
