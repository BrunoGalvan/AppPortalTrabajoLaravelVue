<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worksplace extends Model
{
    use HasFactory;
    static $rules = [
		'title' => 'required',
        'description' => 'required',
		'type_workday_id' => 'required',
        'salary' => 'required',

    ];

    static $customMessages = [
        'title.required' => 'Titulo de oferta requerido',
        'description.required' => 'Descripcion de oferta requerido',
        'type_workday_id.required' => 'Tipo de jornada requerido',
        'salary.required' => 'Salario requerido',
    ];
    protected $table = 'tb_worksplaces';
    
    protected $fillable = [
        'title',
        'description',
        'type_workday_id',
        'salary',
    ];
}
