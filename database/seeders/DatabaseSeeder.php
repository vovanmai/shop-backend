<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::create([
            'name' => "Lionel vo",
            'email' => "vovanmai.dt3@gmail.com",
            'password' => "secret",
            'status' => Admin::STATUS_ACTIVE,
        ]);
        Admin::create([
            'name' => "Lionel vo",
            'email' => "ad@gmail.com",
            'password' => "secret",
            'status' => Admin::STATUS_ACTIVE,
        ]);

        for ($i = 1; $i <= 10; $i++) {
            $company = Company::create([
                'name' => "Company {$i}",
                'status' => Company::STATUS_APPROVED,
            ]);

            $roleSupperAdmin = Role::create([
                'name' => 'Supper admin',
                'company_id' => $company->id,
                'type' => Role::TYPE_DEFAULT
            ]);

            User::create([
                'company_id' => $company->id,
                'name' => "Lionel vo",
                'status' => User::STATUS_ACTIVE,
                'email' => "vovanmai.dt3@gmail.com",
                'password' => "secret{$i}",
                'role_id' => $roleSupperAdmin->id,
            ]);
        }
    }
}
