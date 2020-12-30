<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Auth\TokenCreateRequest;

class LoginController extends Controller
{
    /**
     * login
     * get a token
     * @return \Illuminate\Http\Response (JSON)
     */
    public function api_login(TokenCreateRequest $request){
        if(!\Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            return response()->json([
                'message_type' => __('error'),
                'message_text' => __('Incorrect user or password'),
            ], 401);
        }

        $user = \Auth::user();
        $credentials = $user->createToken(__('Access from API client'));

        return response()->json([
            'user' => $user,
            'credentials' => $credentials
        ]);
    }
    
    /**
     * logout
     * revoke a token
     * @return \Illuminate\Http\Response (JSON)
     */
    public function api_logout(Request $request){
        $request->user()->token()->revoke();

        return response()->json([
            'message_type' => __('success'),
            'message_text' => __('See you later :name', ['name' => $request->user()->name]),
        ]);
    }

}
