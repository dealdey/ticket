<?php

use Illuminate\Database\Seeder;
use App\Department;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create(['name' =>'Engineering']);
        Department::create(['name' => 'Consumer Management']);
        Department::create(['name' => 'Business Intelligence& Growth']);
        Department::create(['name' => 'Finance']);
        Department::create(['name' => 'Executive']);
        Department::create(['name' => 'Partner Management']);
        Department::create(['name' => 'People Management']);
    }
}
