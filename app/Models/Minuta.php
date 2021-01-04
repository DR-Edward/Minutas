<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Helpers\ImageHandler;

class Minuta extends Model
{
    use HasFactory;

    protected $with = ['minutas_acuerdos', 'minutas_participantes', 'minutas_evidencias'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'fecha' => 'datetime:Y-m-d',
        'hora_inicio' => 'datetime:H:i:s'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_id',
        'objetivo',
        'lugar',
        'fecha',
        'hora_inicio',
    ];

    public function minutas_acuerdos(){
        return $this->hasMany(MinutasAcuerdo::class);
    }
    
    public function minutas_participantes(){
        return $this->hasMany(MinutasParticipante::class);
    }
    
    public function minutas_evidencias(){
        return $this->hasMany(MinutasEvidencia::class);
    }

    public static function storeOrUpdate($store = [], $notFriendsIds = [], $data = [], $id = null){
        $data['usuario_id'] = \Auth::id();
        $participantes = User::find($store)
            ->makeVisible(['usuario_id','nombre'])
            ->toArray();

        if($id){
            $minuta = Minuta::findOrFail($id);
            $minuta->update($data);
        }else{
            $minuta = Minuta::create($data);
        }

        if(array_key_exists('evidencias', $data)){
            $imagesData = ImageHandler::store($data['evidencias']);
            // dd($imagesData);
            $minuta->minutas_evidencias()->delete();
            $minuta->minutas_evidencias()->createMany($imagesData['links']);
        }
        $minuta->minutas_acuerdos()->delete();
        $minuta->minutas_acuerdos()->createMany($data['acuerdos']);
        $minuta->minutas_participantes()->delete();
        $minuta->minutas_participantes()->createMany($participantes);

        $saved = Minuta::findOrFail($minuta->id);

        $notFriends = User::select([
            'id',
            'name',
            'apellido_paterno',
            'apellido_materno'
        ])->find($notFriendsIds);

        return [
            'data' => $saved,
            'not_friends' => $notFriends
        ];
    }

}
