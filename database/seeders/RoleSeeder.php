<?php

// database/seeders/RoleSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::create(['name'=>'admin']);
        $userRole = Role::create(['name'=>'user']);

        $adminPermission = Permission::create(['name'=>'admin-access']);
        $userPermission = Permission::create(['name'=>'user-access']);

        $adminRole->permissions()->attach($adminPermission);
        $userRole->permission()->attach($userPermission);
    }

}
