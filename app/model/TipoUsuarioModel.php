<?php

namespace Jugueteria\model;

use Illuminate\Database\Eloquent\Model;

class TipoUsuarioModel extends Model
{
    protected $primaryKey = "ID";
    protected $table = "TipoUsuario";
    protected $fillable = [
		'ID',
		'Nombre'
    ];
}
