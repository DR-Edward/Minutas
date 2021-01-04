<?php

namespace App\Http\Requests\Amigo;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Amigo;

class AcceptOrDeclineAmigoRequest extends FormRequest
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
            "aceptada" => [
                'required',
                "boolean",
            ],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $path = explode("/", $this->getRequestUri());
        $user = \Auth::user();
        $friend = Amigo::where('id', end($path))
            ->where('solicitado_id', $user->id)
            ->first(); 
        $validator->after(function ($validator) use ($friend) {
            if (!$friend) {
                $validator->errors()->add('aceptada', __('Friendship request does not exist.'));
            }
        });
    }
}
