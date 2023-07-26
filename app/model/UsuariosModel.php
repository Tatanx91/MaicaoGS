<?php

namespace Jugueteria\model;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;// as AuthJWT;//enticatableUserContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

//class UsuariosModel extends Model
class UsuariosModel extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $table='Usuario';

    protected $primaryKey="ID";

    public $timestamps=false;


    protected $fillable=[
    'ID',
    'Contrasena',
    'Correo',
    'IdTipoUsuario',
    'Confirmado',
    'Login',
    'CodigoConf'
    ];

    protected $guarded =[];
}