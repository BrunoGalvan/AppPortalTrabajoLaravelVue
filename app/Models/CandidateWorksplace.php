<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateWorksplace extends Model
{
    use HasFactory;
    static $rules = [
		'file_cv' => 'required|mimes:pdf',
        'message' => 'required',
    ];

    static $customMessages = [
        'file_cv.required' => 'CV requerido',
        'file_cv.mimes' => 'El formato del archivo debe ser solo pdf',
        'message.required' => 'Envia un mensaje para que tengas mas opciones'
    ];
    protected $table = 'candidates_has_worksplaces';
    protected $fillable = ['candidate_id','worksplace_id','file_cv','message'];
}
