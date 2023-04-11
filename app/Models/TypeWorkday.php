<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeWorkday extends Model
{
    use HasFactory;
    protected $table = 'tb_types_workday';
    protected $fillable = ['name'];
}
