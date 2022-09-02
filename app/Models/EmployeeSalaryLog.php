<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSalaryLog extends Model
{
	protected $table = 'employee_salary_log';
    protected $fillable = [
        'amt',
        'emp_salary_id',
        'salary_id',
        'custom_salary',
        'start_date',
        'end_date',
        'custom_salary',
        'created_at',
        'updated_at',
    ];
}
