<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            'name' => ['string', 'max:191'],
            'apellido_paterno' => ['string', 'max:191'],
            'apellido_materno' => ['string', 'max:191'],
            'fecha_nacimiento' => ['date_format:Y-m-d'],
            'sexo' => ['string', 'max:1'],
            'imagen' => ['string', 'max:191'],
            'firma' => ['string', 'max:191'],
            'token_firebase' => ['string', 'max:191'],
            'solicitar' => ['boolean'],
            'email' => [
                'string',
                'email',
                'max:191',
                Rule::unique(User::class),
            ],
        ];
    }
}
