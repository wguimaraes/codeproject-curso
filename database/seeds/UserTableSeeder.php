<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        factory(\CodeProject\Entities\User::class)->create([
        		'name' => 'user',
        		'email' => 'user@user.com',
        		'password' => bcrypt('123456'),
        		'remember_token' => str_random(10),
        ]);
        
        factory(\CodeProject\Entities\User::class)->create([
        		'name' => 'Wesley',
        		'email' => 'wesleywilliams@gmail.com',
        		'password' => bcrypt('123456'),
        		'remember_token' => str_random(10),
        ]);
        
        //CodeProject\Entities\Project::truncate();
        factory(CodeProject\Entities\User::class, 10)->create();
    }
}
