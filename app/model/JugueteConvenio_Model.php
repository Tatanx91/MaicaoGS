<?php

namespace Jugueteria\model;

use Illuminate\Database\Eloquent\Model;

class JugueteConvenio_Model extends Model
{
    protected $primaryKey = "ID";
    protected $table = "JugueteConvenio";
    protected $fillable = [
		'IdConvenio',
		'IdJuguete',
		'StockInicial',
		'StockActual',
		'EdadInicial',
		'EdadFinal',
		'IdGenero'
    ];
}
