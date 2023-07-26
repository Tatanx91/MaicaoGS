<?php

namespace Jugueteria;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable implements JWTSubject
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

    protected $table='usuarios';

    protected $primaryKey="idUsuario";

    public $timestamps=false;


    protected $fillable=[
    'IdUsuario',
	'NombreUsuario',
	'ApellidoUsuario',
	'IdTipoDocumento',
	'NumeroDocumento',
	'Contrasena',
    'Estado',
    'Correo'
    ];

    protected $guarded =[];
}
