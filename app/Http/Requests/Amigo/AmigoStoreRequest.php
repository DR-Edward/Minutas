<?php

namespace App\Http\Requests\Amigo;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Amigo;

class AmigoStoreRequest extends FormRequest
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
            "solicitado_id" => [
                "integer",
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
        $user = \Auth::user();
        $input_id = $this->solicitado_id;

        $amigo = Amigo::
            where(function($q) use ($input_id, $user){
                $q->where('aceptada', true)
                    ->where('solicitante_id', $user->id)
                    ->where('solicitado_id', $input_id);
            })
            ->orWhere(function($q) use ($input_id, $user){
                $q->where('aceptada', true)
                    ->where('solicitado_id', $user->id)
                    ->where('solicitante_id', $input_id);
            })
            ->get();

        $validator->after(function ($validator) use ($user, $amigo) {
            if ($this->solicitado_id == $user->id) {
                $validator->errors()->add('solicitado_id', __('The provided id does match your current user id.'));
            }
            if (count($amigo) > 0) {
                $validator->errors()->add('solicitado_id', __('The provided id does match with one of your friends.'));
            }
        });
    }
}
