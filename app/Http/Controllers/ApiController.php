<?php

namespace App\Http\Controllers;

use App\Models\AccountList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{

    public function login(Request $request)
    {
        return "login";
    }
}