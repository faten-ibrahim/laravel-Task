<?php

use App\City;
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        factory(Role::class, 200)->create();
        //Seed the countries
        $this->call(CountriesSeeder::class);
        $this->command->info('Seeded the countries!');

        factory(City::class, 20)->create();
        factory(User::class, 4)->create();
        $this->call(CreateRolesAndPermissionsSeeder::class);
        $this->call(JobsTableSeeder::class);
    }
}
