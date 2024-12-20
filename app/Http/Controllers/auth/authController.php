<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens; // If using Sanctum for token authentication

class AuthController extends Controller
{
    public function loginUser(Request $request)
    {
        // Validate the request inputs
        $validation = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email', 
            'password' => 'required|string|min:6',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validation->errors()->first()
            ]);
        }

        // Attempt to log the user in using the provided credentials
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            // Check if the logged-in user has the 'admin' role
            $user = Auth::user();

            if ($user->hasRole('admin')) {
                // Optionally, you can return a success response with the user's information or token
                $token = $user->createToken('Admin-Token')->plainTextToken;  // Create token if using Sanctum
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successful.',
                    'user' => $user,
                    // 'token' => $token  // Include the token in the response (if using Sanctum)
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have the necessary permissions to log in as an admin.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Incorrect credentials.'
            ]);
        }
    }
}

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Log; 
// use App\Models\User;
// use Validator;

// class AuthController extends Controller
// {
//     public function loginUser(Request $request)
//     {
//         $validation = Validator::make($request->all(), [
//             'email' => 'required|string|email|exists:users,email', 
//             'password' => 'required|string|min:6',
//         ]);

//         if($validation->fails()){
//             return response()->json(['status'=>'error','message'=>$validation->errors()->first()]);
//         }else{
//             $cred = array('email'=>$request->email,'password'=>$request->password);
//             if(Auth::attempt($cred,false)){
//                 if(Auth::User()->hasRole('admin')){

//                 }
//             }else{
//                 return response()->json(['status'=>'error','message'=>'Wrong Cred']);
//             }
//         }

//     }
// }
