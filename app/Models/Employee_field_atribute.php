<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee_field_atribute extends Model
{
	protected $table = 'employee_field_atribute';
    protected $fillable = [
        'field_id',
        'option_name',
        'option_value',
        'created_by',
        // 'created_at',
        // 'updated_at'
    ];
}
