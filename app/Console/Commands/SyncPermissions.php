<?php

namespace App\Console\Commands;

use App\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync permissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $permissions = [
            Permission::GROUP_USER => [
                Permission::ACTION_LIST,
                Permission::ACTION_CREATE,
                Permission::ACTION_EDIT,
                Permission::ACTION_DELETE,
                Permission::ACTION_DETAIL,
            ],
            Permission::GROUP_ROLE => [
                Permission::ACTION_LIST,
                Permission::ACTION_CREATE,
                Permission::ACTION_EDIT,
                Permission::ACTION_DELETE,
                Permission::ACTION_DETAIL,
            ]
        ];

        $data = [];

        foreach ($permissions as $group => $actions) {
            $actions = array_map(function ($action) use ($group) {
                return [
                    'group' => $group,
                    'action' => $action
                ];
            }, $actions);
            $data = [...$data, ...$actions];
        }

        try {
            DB::beginTransaction();
            foreach ($data as $item) {
                $permission = Permission::where('group', $item['group'])
                    ->where('action', $item['action'])
                    ->exists();

                if (!$permission) {
                    Permission::create($item);
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            DB::rollBack();
        }
    }
}
