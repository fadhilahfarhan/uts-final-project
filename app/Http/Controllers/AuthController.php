<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        #memvalidasi inputan
        $validated = Validator::make($request->all(), [
            'name' => 'required|min:2|max:50',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validated->fails()) {
            return $this->response(400, $validated->getMessageBag()->first());
        }

        #membuat resource user baru
        #menggunakan hash untuk encyript
        $create = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]
        );

        #jika berhasil
        if ($create) {
            return $this->response(200, 'User is created successfully');
        }

        #dan jika ada gagal
        return $this->response(200, 'Something Wrong!!!');
    }

    # untuk login
    # di VScode createToken terlihat merah atau error tapi di postman berfungsi
    public function login(Request $request)
    {
        if (Auth::attempt($request->all())) {
            $token = Auth::user()->createToken('auth_token');

            return response()->json([
                'message' => 'Login Successfully',
                'token' => $token->plainTextToken
            ], 200);
        }

        return $this->response(401, 'Username or Password is Wrong');
    }
}
