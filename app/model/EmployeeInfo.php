<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class EmployeeInfo extends Model
{
    protected $primarykey = 'id';

    protected $fillable = [
        'birthday', 'employee_id',
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}
