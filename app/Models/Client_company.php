<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client_company extends Model
{
	protected $table = 'client_company';
    protected $fillable = [
        'name','city','branch_id','created_by'
    ];
}
