<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpRole extends Model
{
	protected $table = 'emp_role';
    protected $fillable = [
        'name','created_at','updated_at'
    ];
}
