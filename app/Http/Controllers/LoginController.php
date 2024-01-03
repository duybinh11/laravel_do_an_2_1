<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class LoginController extends Controller
{


    public function register_account(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|unique:users,username',
                'address' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'phone' => 'required|unique:users,phone|min:9'
            ]);

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'token' => $this->createToken()
            ]);

            return Response()->json(['status' => true, 'user' => $user]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            return Response()->json(['status' => false, 'erorr' => $errors]);
        }
    }

    public function login(Request $request)
    {
        $user = Auth::attempt(['email' => $request->email, 'password' => ($request->password)]);
        if ($user) {
            $userData = Auth::user();
            return Response()->json(['status' => true, 'user' => $userData]);
        } else {
            return Response()->json(['status' => false]);
        }
    }

    public function login_token(Request $request)
    {
        $user = User::where('token', $request->token)->first();
        if ($user != null) {
            return Response()->json(['status' => true, 'user' => $user]);
        } else {
            return Response()->json(['status' => false]);
        }
    }

    public function createToken()
    {
        $randum = Str::random(60);
        return  hash('sha256', $randum);
    }
}
