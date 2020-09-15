<?php

use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\model\Employee::class,100)->create()->each(function($u) {
        //     $u->info()->save(factory(App\model\EmployeeInfo::class)->make());
        // });
        factory(App\model\Employee::class,100)->create()->each(function($employee) {
            $employee->info()->save(factory(App\model\EmployeeInfo::class)->make());
        });

    }
}
