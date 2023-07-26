<?php

namespace Jugueteria\model;

use Illuminate\Database\Eloquent\Model;

class Genero_model extends Model
{
    protected $primaryKey = "ID";
    protected $table = "Genero";
    protected $fillable = [
    	'Codigo',
		'Nombre'
    ];
}
