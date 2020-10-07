<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $priorities = array(
            array('name' => 'Low'),
            array('name' => 'Medium'),
            array('name' => 'High'),
        );
        DB::table('priorities')->insert($priorities);

        $statuses = array(
            array('name' => 'Planning'),
            array('name' => 'Perfoming'),
            array('name' => 'Closed'),
            array('name' => 'Canceled'),
        );
        DB::table('statuses')->insert($statuses);

    }
}
