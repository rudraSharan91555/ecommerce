<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Hash;

use Auth;

class AuthController extends Controller
{
    public function createCustomer()
    {
        $user = new User();
        $user->name  = 'Amin';
        $user->email = 'admin@gmail.com';
        $user->password = Hash::make('123456');
        $user->save();
        
        $admin = Role::where('slug','admin')->first();

        $user->roles()->attach($admin);
    }
}