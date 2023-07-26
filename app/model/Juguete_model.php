<?php

namespace Jugueteria\model;

use Illuminate\Database\Eloquent\Model;

class Juguete_model extends Model
{    
	protected $primaryKey = "ID";
    protected $table = "Juguete";
    protected $fillable = [
		'NumeroReferencia',
		'Nombre',
		'Dimensiones',
		'EdadInicial',
		'EdadFinal',
		'IdGenero',
		'cantidad',
		'descripcion',
		'estado'
    ];
}
