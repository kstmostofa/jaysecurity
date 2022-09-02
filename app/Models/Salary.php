<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
	protected $table = 'salary';
    protected $fillable = [
        'amt',
        'company_client_id',
        'company_client_unit_id',
        'role_id',
        'is_active',
        'start_date',
        'end_date',
        'created_by',
        'created_at',
        'updated_at',
    ];
}
