<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $primarykey = 'id';

    protected $fillable = [
        'name',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
