<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee_field_data extends Model
{
	protected $table = 'employee_field_data';
    protected $fillable = [
        'field_id',
        'field_value',
        'emp_id',
        'created_by'
    ];
}
