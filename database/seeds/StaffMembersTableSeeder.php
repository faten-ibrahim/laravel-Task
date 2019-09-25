<?php

use Illuminate\Database\Seeder;

class StaffMembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('staff_members')->delete();
        $staff = array(
            array( 'user_id' => 1,'job_id'=>3,'role_id'=>1),
            array( 'user_id' => 2,'job_id'=>4,'role_id'=>2),
            array( 'user_id' => 3,'job_id'=>5,'role_id'=>3),
            array( 'user_id' => 4,'job_id'=>6,'role_id'=>6),
            array( 'user_id' => 5,'job_id'=>7,'role_id'=>7),
            array( 'user_id' => 6,'job_id'=>3,'role_id'=>8),
            array( 'user_id' => 7,'job_id'=>4,'role_id'=>9),
            array( 'user_id' => 8,'job_id'=>6,'role_id'=>5),
            array( 'user_id' => 9,'job_id'=>3,'role_id'=>1),
            array( 'user_id' => 10,'job_id'=>3,'role_id'=>3),
            array( 'user_id' => 11,'job_id'=>2,'role_id'=>5),
            array( 'user_id' => 12,'job_id'=>8,'role_id'=>1),
        );

        DB::table('staff_members')->insert($staff);
    }
}
