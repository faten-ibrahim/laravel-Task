<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class CreateRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'city-list',
            'city-create',
            'city-edit',
            'city-delete',
            'job-list',
            'job-create',
            'job-edit',
            'job-delete',
            'staff-list',
            'staff-create',
            'staff-edit',
            'staff-delete',
            // 'staff-active',
            'visitor-list',
            'visitor-delete',
            'visitor-edit',
            'visitor-create',
            'news-list',
            'news-delete',
            'news-edit',
            'news-create',
            'event-list', 
            'event-delete', 
            'event-edit', 
            'event-create'
        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }


        $user = User::create([
            'first_name' => 'Hardik Savani',
            'last_name' => 'Hai sdugu',
            'email' => 'admin@gmail.com',
            'phone' => '01155959747',
            'password' => Hash::make('12345678'),
            'city_id' =>1,
            'country_id' => 1,
            'type'=>'admin'
        ]);

        $role = Role::create(['name' => 'Admin', 'description' => 'any description']);
        $role->givePermissionTo(Permission::all());
        $user->assignRole([$role->id]);


        $user = User::create([
            'first_name' => 'ali',
            'last_name' => 'ali',
            'email' => 'visitor@gmail.com',
            'phone' => '01155959788',
            'password' => Hash::make('12345678'),
            'city_id' =>1,
            'country_id' => 1,
        ]);

        // $role2 = Role::create(['name' => 'Visitor', 'description' => 'any description']);

        // $permissions = Permission::pluck('id', 'id')->all();

        // $role->syncPermissions($permissions);
        // $role2->givePermissionTo('role-list');
        // $role2->givePermissionTo('city-list');
        // $role2->givePermissionTo('job-list');
        // $user->assignRole([$role2->id]);


        $user = User::create([
            'first_name' => 'kamel',
            'last_name' => 'ali',
            'email' => 'kamel@gmail.com',
            'phone' => '01155959755',
            'password' => Hash::make('12345678'),
            'city_id' =>1,
            'country_id' => 1,
        ]);

        $user->givePermissionTo('role-list');
        $user->givePermissionTo('city-list');
        $user->givePermissionTo('job-list');
        $user->givePermissionTo('staff-list');
        $user->givePermissionTo('news-list');
        $user->givePermissionTo('event-list');
    }
}
