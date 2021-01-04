<?php

namespace App\Http\Requests\Minuta;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class MinutaStoreRequest extends FormRequest
{
    /**
     * Users Party.
     *
     */
     private $party = ['in' => null, 'out' => null];

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
            "objetivo" => [
                'required',
                'string',
            ],
            "lugar" => [
                'required',
                'string',
            ],
            "fecha" => [
                'required', 
                'date_format:Y-m-d',
            ],
            "hora_inicio" => [
                'required', 
                'date_format:H:i:s',
            ],
            "participantes" => [
                'required',
                'array',
            ],
            "participantes.*" => [
                'integer',
            ],
            "acuerdos" => [
                'required',
                'array',
            ],
            "acuerdos.*.usuario_id" => [
                'required',
                'integer',
            ],
            "acuerdos.*.responsable" => [
                'required',
                'string',
            ],
            "acuerdos.*.actividad" => [
                'required',
                'string',
            ],
            "acuerdos.*.fecha_compromiso" => [
                'required',
                'date_format:Y-m-d',
            ],
            "evidencias" => [
                'array',
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
        $userId = \Auth::id();
        $participantes = $this->participantes;

        $amigos = User::whereHas('myFriends', function ($q) use($userId){
            $q->where('solicitante_id', $userId);
        })
        ->orWhereHas('friendOf', function ($q) use($userId){
            $q->where('solicitado_id', $userId);
        })
        ->get()
        ->makeVisible('friends')
        ->first()
        ->friends;

        $validator->after(function ($validator) use ($amigos, $participantes) {
            if (!$amigos) {
                $validator->errors()->add('participantes', __('Can not find users to be jointed.'));
            }else {
                $id_array = array_map(function ($element) {
                    return $element['id'];
                }, $amigos); 
                $this->party['in'] = array_intersect($id_array, $participantes);
                $this->party['out'] = array_diff($participantes, $id_array);
            }
            if(!$this->party['in']){
                $validator->errors()->add('participantes', __('Can not find users to be jointed.'));
            }
        });
    }

    /**
     * keeps and return a users party 
     * 
     * @return array
     */
     function persist()
     {
        return $this->party;
     }
}
