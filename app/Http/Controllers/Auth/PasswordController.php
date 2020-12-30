<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\TemporalPassword;
use App\Http\Requests\Auth\PasswordUpdateRequest;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    /**
     * Register
     * store a new user
     * @return \Illuminate\Http\Response (JSON)
     */
    public function update(PasswordUpdateRequest $request){
        $user = \Auth::user();

        $user->forceFill([
            'password' =>  Hash::make($request->input('password')),
        ])->save();

        return response()->json([
            'message_type' => __('success'),
            'message_text' => __('Password updated'),
        ]);
    }

}
