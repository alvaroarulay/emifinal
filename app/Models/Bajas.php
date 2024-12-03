<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bajas extends Model
{
    use HasFactory;
    protected $table = "bajas";
    protected $fillable = [
        'entidad', 
        'unnidad',
        'codigo',
        'codbaja',
        'codcont',
        'codaux',
        'codofic',
        'codresp',
        'costo',
        'depacu_ant',
        'descrip',
        'd_baja',
        'dia',
        'm_baja',
        'mes', 
        'a_baja',
        'año', 
        'b_rev',
        'vidautil',
        'resolucion',
        'observ',
        'motivo',
        'depacu',
        'actua',
        'depgestion',
        'cosbajini',
        'usuar',
        'feult',
        'fec_mod',
        'usu_mod',
    ];

}

