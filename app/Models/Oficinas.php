<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class Oficinas extends Model
{
    use HasFactory;
    protected $table = "oficina";
    protected $fillable = [
        'id',
        'entidad',
        'unidad',
        'codofic',
        'nomofic',
        'observ',
        'feult',
        'usuar',
        'api_estado',
    ];
    
    public function obtenerOficinas()
    {
        return Oficinas::all();
    }
    public function obtenerOficinaPorId($id)
    {
        return Oficinas::find($id);
    }
    public function actualizarDatos(){
        $oficinas=Oficinas::all();
        foreach ($oficinas as $oficina) {
            $oficina->delete();
        }
        $table = new TableReader('C:/vsiaf/dbfs/OFICINA.dbf',['encoding' => 'cp1251']);
        while ($record = $table->nextRecord()) {
            DB::table('oficina')->insert([
            'entidad' => $record->get('entidad'),
            'unidad' => $record->get('unidad'),
            'codofic' => $record->get('codofic'),
            'nomofic' => $record->get('nomofic'),
            'observ' => $record->get('observ'),
            'feult' => $record->get('feult'),
            'usuar' => $record->get('usuar'),
            'api_estado' => $record->get('api_estado'),
          ]);
        }
        return Oficinas::all(); 
      }
}
