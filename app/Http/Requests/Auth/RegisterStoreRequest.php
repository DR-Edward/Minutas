<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Password;
use Illuminate\Validation\Rule;
use App\Models\User;

class RegisterStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'apellido_paterno' => ['required', 'string', 'max:191'],
            'apellido_materno' => ['required', 'string', 'max:191'],
            'fecha_nacimiento' => ['required', 'date_format:Y-m-d'],
            'sexo' => ['required', 'string', 'max:1'],
            'imagen' => ['required', 'string', 'max:191'],
            'firma' => ['required', 'string', 'max:191'],
            'token_firebase' => ['required', 'string', 'max:191'],
            'solicitar' => ['required', 'boolean'],
            'email' => [
                'required',
                'string',
                'email',
                'max:191',
                Rule::unique(User::class),
            ],
            // 'password'    => ['required', 'string', new Password, 'confirmed'],
            // 'password'    => ['required', 'string', 'max:191'],
        ];
    }
}
