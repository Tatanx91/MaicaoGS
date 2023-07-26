<?php

namespace Jugueteria\model;

use Illuminate\Database\Eloquent\Model;

class Usuario_Model extends Model
{
	protected $primaryKey = "ID";
    protected $table = "Usuario";
    protected $fillable = [
		'Login',
		'Password',
		'Confirmado',
		'CodigoConf'
    ];
}
