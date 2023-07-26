<?php

namespace Jugueteria\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JugueteRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "NumeroReferencia" => "required",
            "NombreJuguete" => "required",
            "Dimensiones" => "required",
            "EdadInicial" => "required",
            "EdadFinal" => "required",
            "IdGenero" => "required"
        ];
    }
}
