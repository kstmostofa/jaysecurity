<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration',
        'max_users',
        'max_employees',
        'max_venders',
        'description',
        'image',
    ];

    public static $arrDuration = [
        'unlimited' => 'Unlimited',
        'month' => 'Per Month',
        'year' => 'Per Year',
    ];

    public static function total_plan()
    {
        return Plan::count();
    }

    public static function most_purchese_plan()
    {
        $free_plan = Plan::where('price', '<=', 0)->first()->id;

        return User:: select('plans.name','plans.id', DB::raw('count(*) as total'))
                   ->join('plans', 'plans.id' ,'=', 'users.plan')
                   ->where('type', '=', 'company')
                   ->where('plan', '!=', $free_plan)
                   ->orderBy('total','Desc')
                   ->groupBy('plans.name','plans.id')
                   ->first();
    }

    // public function user()
    // {
    //     return $this->hasOne('App\Models\User', 'id', 'user_id');
    // }
}
