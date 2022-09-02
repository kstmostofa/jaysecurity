<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee_field extends Model
{
	protected $table = 'employee_field';
    protected $fillable = [
        'field_name',
        'type',
        'status',
        'mandatory',
        'created_by'
    ];
}
