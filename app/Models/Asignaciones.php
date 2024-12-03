<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignaciones extends Model
{
    use HasFactory; 
    
    protected $table = "asignacion";
    protected $fillable = [
        'codofic',
        'codresp',
        'usuario',
    ];
}
