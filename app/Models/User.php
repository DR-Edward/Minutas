<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'sexo',
        'imagen',
        'firma',
        'token_firebase',
        'solicitar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'friends',
        'myFriends',
        'friendOf',
        'usuario_id',
        'nombre'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'usuario_id',
        'nombre',
        'full_name',
        'friends',
    ];

    /**
     * Get the full name.
     *
     * @param  string  $value
     * @return string
     */
    public function getFullNameAttribute($value)
    {
        return $this->name." ".$this->apellido_paterno." ".$this->apellido_materno;
    }
    
    /**
     * Get the id names usuario_id.
     *
     * @param  string  $value
     * @return string
     */
    public function getUsuarioIdAttribute($value)
    {
        return $this->id;
    }
    
    /**
     * Get the name named as nombre.
     *
     * @param  string  $value
     * @return string
     */
    public function getNombreAttribute($value)
    {
        return $this->name;
    }
    
    /**
     * Get the full list of friends.
     *
     * @param  string  $value
     * @return string
     */
    public function getFriendsAttribute($value)
    {
        return array_merge($this->myFriends->toArray(), $this->friendOf->toArray());
    }
    
    /**
     * List of friends that I sended an invitation
     * 
     */
    public function myFriends()
    {
        return $this->belongsToMany(User::class, 'amigos', 'solicitante_id', 'solicitado_id')->where('aceptada', true);
    }

    /**
     * List of friends that I recived an invitation
     * 
     */
    public function friendOf()
    {
        return $this->belongsToMany(User::class, 'amigos', 'solicitado_id', 'solicitante_id')->where('aceptada', true);
    }
    
}
