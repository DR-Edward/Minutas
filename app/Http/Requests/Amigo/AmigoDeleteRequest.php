<?php

namespace App\Http\Requests\Amigo;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Amigo;

class AmigoDeleteRequest extends FormRequest
{
    /**
     * User to delete.
     *
     */
    private $user = null;

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
            //
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
        $input_id = end($path);

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
                $validator->errors()->add('0', __('The provided id does match your current user id.'));
            }
            if (count($amigo) < 1) {
                $validator->errors()->add('0', __('The provided id does not match with one of your friends.'));
            } else $this->user = $amigo[0];
        });
    }

    /**
     * keeps and return a user to be deleted
     * 
     * @return User
     */
    function persist()
    {
        return $this->user;
    }
}
