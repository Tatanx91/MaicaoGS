<?php

namespace Jugueteria\model;

use Illuminate\Database\Eloquent\Model;

class AdministradorModel extends Model
{
    protected $primaryKey = "ID";
    protected $table = "Administrador";
    protected $fillable = [
		'ID',
		'IdUsuario',
		'NombreUsuario',
		'IdTipoDocumento',
		'NumeroDocumento',
		'Estado',
		'Updated_At',
		'Created_At'
    ];
}
