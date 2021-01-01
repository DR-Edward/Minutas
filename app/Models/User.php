<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'friendOf'
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
        return $this->belongsToMany(User::class, 'amigos', 'solicitante_id', 'solicitado_id');
    }

    /**
     * List of friends that I recived an invitation
     * 
     */
    public function friendOf()
    {
        return $this->belongsToMany(User::class, 'amigos', 'solicitado_id', 'solicitante_id');
    }
    
}
