<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function CreateUser(Request $request){

    }

    public function StoreUser(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'user_name' => 'required',
            'avatar' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
           return json_encode($validator->errors());
        }
        $token = md5($request->email.$request->password);
        $data = array(
            "name" => $request->name,
            "user_name" => $request->user_name,
            "email" => $request->email,
            "password" => $request->password,
            "avatar" => $request->avatar,
            "user_role" => 'user',
            "token" => $token
        );
        $user = User::create($data);
        if(isset($user)){
            return json_encode(array(
                "success" => true,
                "message" => "User created successfully",
                "token" => $token
                )
            );
        }
        return json_encode(array(
            "success" => false,
            "message" => "Registration failed"
            )
        );
    }

    public function Login(Request $request){
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
           return json_encode($validator->errors());
        }
        $user_name = $request->user_name;
        $password = $request->password;
        $user = User::where('user_name', $user_name)->where('password', $password)->first();
        if(!is_null($user)){
            return json_encode(array(
                "success" => true,
                "message" => "User logged-in successfully",
                "token" => $user->token
                )
            );
        }

    }

    public function UpdateProfile(Request $request){
        $token = $request->header('token');
        if(User::where('token', $token)->where('user_role', 'user')->Exists()){
            // return $request->all();
            $user = User::where('token', $token)->update($request->all());
            // $user = 1;
            if(!is_null($user)){
                return json_encode(array(
                    "success" => true,
                    "message" => "Profile updated successfully"
                    )
                );
            }
        }
        return json_encode(array(
            "success" => false,
            "message" => "Un-Authorized"
            )
        );
    }
}
