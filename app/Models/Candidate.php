<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    static $rules = [
		'n_document' => 'required',
        'type_document_id' => 'required',
        'last_names' => 'required',
        'dates_birth' => 'required|date',
        'user_id' => 'required',

    ];

    static $customMessages = [
        'n_document.required' => 'Numero de documento requerido',
        'type_document_id.required' => 'Tipo de documento requerido',
        'last_names.required' => 'Porfavor ingrese apellidos',
        'dates_birth.required' => 'Fecha de nacimiento requerido',
    ];
    protected $table = 'tb_candidates';
    protected $fillable = ['n_document','type_document_id','names','last_names','dates_birth','email','user_id'];
}
