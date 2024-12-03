<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unidadadmin;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class CodigoContable extends Model
{
    use HasFactory;
    protected $table = "codcont";
    protected $fillable = [
        'codcont',
        'nombre',
        'vidautil',
        'observ', 
        'depreciar', 
        'actualizar', 
        'feult',
        'usuar',
    ];
    protected $hidden = ['id'];
    public function obtenerCodigoContable()
    {
        return CodigoContable::all();
    }
    public function obtenerCodigoContablePorId($id)
    {
        $unidad = Unidadadmin::where('estado','=','1')->first();
        $codcont = CodigoContable::find($id)->where('unidad','=',$unidad->unidad)->get();
        return $codcont;
    }
    public function actualizarDatos(){
        $codigoscontables=CodigoContable::all();
        foreach ($codigoscontables as $codigocontable) {
            $codigocontable->delete();
        }
        $table = new TableReader('C:/vsiaf/dbfs/CODCONT.dbf',['encoding' => 'cp1251']);
        while ($record = $table->nextRecord()) {
           
        }
        return CodigoContable::all(); 
      }
}           
