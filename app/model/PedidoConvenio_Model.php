<?php

namespace Jugueteria\model;

use Illuminate\Database\Eloquent\Model;

class PedidoConvenio_Model extends Model
{
    protected $primaryKey = "ID";
    protected $table = "PedidoConvenio";
    protected $fillable = [
		'IdJugueteConvenio',
		'IdHijoEmpleado',
		'CorreoEnviado'
    ];
}
