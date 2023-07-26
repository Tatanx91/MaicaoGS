<?php

namespace Jugueteria\model;

use Illuminate\Database\Eloquent\Model;

class Convenio_Model extends Model
{
    protected $primaryKey = "ID";
    protected $table = "Convenio";
    protected $fillable = [
		'IdEmpresa',
		'FechaInicio',
		'FechaFin'
    ];
}
