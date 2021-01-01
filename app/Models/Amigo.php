<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amigo extends Model
{
    use HasFactory;

    protected $with = ['solicitante_user', 'solicitado_user'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'aceptada' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'solicitante_id',
        'solicitado_id',
        'aceptada'
    ];

    public function solicitante_user(){
        return $this->hasOne(User::class, 'id', 'solicitante_id');
    }
    
    public function solicitado_user(){
        return $this->hasOne(User::class, 'id', 'solicitado_id');
    }
}
