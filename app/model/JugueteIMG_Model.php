<?php

namespace Jugueteria\model;

use Illuminate\Database\Eloquent\Model;

class JugueteIMG_Model extends Model
{
 	protected $primaryKey = "ID";
    protected $table = "JugueteImg";
    protected $fillable = [
		'idJuguete',
		'Ruta',
		'Imagen',
		'Extension',
		'Estado'
    ];   //
}
