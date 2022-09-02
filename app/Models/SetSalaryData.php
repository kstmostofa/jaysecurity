<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetSalaryData extends Model
{
	protected $table = 'set_salary_data';
    protected $fillable = [
        'amt',
        'salary_id',
        'role_id',
        'start_date',
        'end_date',
        // 'created_by',
        'created_at',
        'updated_at',
    ];
}
