<?php

use App\Job;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Job::create(['name' => 'reporter', 'description' => 'any description']);
        Job::create(['name' => 'writter', 'description' => 'any description']);

        for ($i = 0; $i < 10; $i++) {
            Job::create([
                'name' => Str::random(10),
                'description' => Str::random(20),
            ]);
        }
    }
}
