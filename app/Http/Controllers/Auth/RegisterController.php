<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\TemporalPassword;
use App\Http\Requests\Auth\RegisterStoreRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /**
     * Register
     * store a new user
     * @return \Illuminate\Http\Response (JSON)
     */
    public function store(RegisterStoreRequest $request){
        $pass = random_int(100000, 999999);
        return Mail::to($request->input('email'))->queue(new TemporalPassword($pass));
        $newUser = User::create([
            'name' => $request->input('name').$pass,
            'email' => $request->input('email'),
            'password' => Hash::make($pass),
        ]);

        Mail::to($request->input('email'))->queue(new TemporalPassword($pass));

        return response()->json($newUser);
    }

}
