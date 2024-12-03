<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Actual extends Model
{
    use HasFactory; 
    protected $table = "actual";
    protected $fillable = [
        'unidad', 
        'entidad',
        'codigo',
        'codcont',
        'codaux',
        'vidautil',
        'descripcion',
        'costo',
        'depacu',
        'mes', 
        'año', 
        'b_rev',
        'dia', 
        'codofic',
        'codresp',
        'observ',
        'dia_ant', 
        'mes_ant', 
        'año_ant',
        'vut_ant',
        'costo_ant',
        'band_ufv', 
        'codestado',
        'cod_rube',
        'nro_conv',
        'org_fin',
        'feult',
        'usuar',
        'api_estado',
        'codigosec',
        'banderas',
        'fec_mod',
        'usu_mod',
    ];
}
