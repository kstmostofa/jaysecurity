<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
	protected $table = 'employee_salary';
    protected $fillable = [
        'amt',
        'emp_id',
        'salary_id',
        'custom_salary',
        'created_at',
        'updated_at',
    ];
}
