<?php

namespace Jugueteria\model;

use Illuminate\Database\Eloquent\Model;

class Novedad_Model extends Model
{
    protected $primaryKey = "ID";
    protected $table = "Novedad";
    protected $fillable = [
		'Novedad',
		'IdEmpleado'
    ];
}
