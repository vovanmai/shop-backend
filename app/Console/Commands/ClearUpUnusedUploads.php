<?php

namespace App\Console\Commands;

use App\Models\Upload;
use Illuminate\Console\Command;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ClearUpUnusedUploads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:unused-uploads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info("[START][ClearUpUnusedUpload][" . now()->format('Y-m-d H:i:s') . "]");
        Upload::query()->whereNull('uploadable_id')
            ->orderBy('id', 'desc')
            ->where('created_at', '<', now()->subMinutes(5))
            ->chunk(100, function ($files) {
                foreach ($files as $file) {
                    $pathname = $file->path . '/' . $file->filename;
                    $exist = Storage::disk('public')->exists($pathname);
                    if ($exist) {
                        Log::info("[ClearUpUnusedUpload][" . now()->format('Y-m-d H:i:s') . "]: {$pathname}");
                        $deleted = Storage::disk('public')->deleteDirectory($file->path);
                        if ($deleted) {
                            $file->delete();
                        }
                    }
                }
        });
        Log::info("[END][ClearUpUnusedUpload][" . now()->format('Y-m-d H:i:s') . "]");
    }
}
