<?php

use Illuminate\Database\Seeder;

class ProjectTaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CodeProject\Entities\Project::truncate();
        factory(CodeProject\Entities\ProjectTask::class, 50)->create();
    }
}
