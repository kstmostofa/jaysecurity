<?php

namespace App\Http\Controllers;

use App\Models\User;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use JWTAuth;
use JWTFactory;
use Validator;

class UserApiController extends Controller
{
    public function register_user(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'name'  => 'required',
                'email' => 'required|unique:users',
                'password' => 'required',
                'type'     => 'required',
                'created_by' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            // return redirect()->json($validator->errors());
        }
    }
}
