<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client_company_unit extends Model
{
    protected $table = 'client_company_unit';
    protected $fillable = [
        'name', 'company_id', 'created_by'
    ];

    public function getBranch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
