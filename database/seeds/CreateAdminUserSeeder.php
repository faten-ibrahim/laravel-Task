<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Hardik Savani',
            'last_name' => 'Hai sdugu',
            'email' => 'admin@gmail.com',
            'phone' =>'01155959747',
            'password' => '12345678'
        ]);

        $role = Role::create(['name' => 'Admin','description'=>'any description']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
