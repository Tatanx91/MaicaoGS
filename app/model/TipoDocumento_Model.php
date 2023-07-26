<?php

namespace Jugueteria\model;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento_Model extends Model
{
    protected $primaryKey = "ID";
    protected $table = "TipoDocumento";
    protected $fillable = [
    	'Codigo',
		'Nombre'
    ];
}
