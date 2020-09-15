<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $primarykey = 'id';

    protected $fillable = [
        'name', 'email', 'company_id',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function info()
    {
        return $this->hasOne(EmployeeInfo::class);
    }
}

