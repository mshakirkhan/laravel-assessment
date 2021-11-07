<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function InviteUser(Request $request){
        $token = $request->header('token');
        if(User::where('token', $token)->where('user_role', 'admin')->Exists()){
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email',
            ]);
            if ($validator->fails()) {
               return json_encode($validator->errors());
            }
            $data = array(
                'email'=>$request->email
            );
            $res = Mail::to($request->email)->send(new \App\Mail\InviteUser($data));
            return json_encode(array(
                "success" => true,
                "message" => "User invited successfully"
                )
            );
        }
        return json_encode(array(
            "success" => false,
            "message" => "Un-Authorized"
            )
        );
    }
}
