<?php

namespace Jugueteria\model;

use Illuminate\Database\Eloquent\Model;

class rel_juguete_img extends Model
{
   	protected $primaryKey = "ID";
    protected $table = "JugueteImg";
    protected $fillable = [
    	'ID',
		'IdJuguete',
		'Ruta',
		'Imagen',
		'Extension',
		'Estado'
    ];
}
