<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class Responsables extends Model
{
    use HasFactory;
    protected $table = "resp";
    protected $fillable = [
        'entidad',
        'unidad',
        'codofic',
        'codresp',
        'nomresp',
        'cargo',
        'observ',
        'ci',
        'feult',
        'usuar',
        'cod_exp',
        'api_estado',
    ];
    
    public function obtenerResponsables()
    {
        return Responsables::all();
    }
    public function obtenerResponsablePorId($id)
    {
        return Responsables::find($id);
    }
    public function actualizarDatos(){
        $responsables=Responsables::all();
        foreach ($responsables as $responsable) {
            $responsable->delete();
        }
        $table = new TableReader('C:/vsiaf/dbfs/resp.dbf',['encoding' => 'cp1251']);
        while ($record = $table->nextRecord()) {
            DB::table('resp')->insert([
            'entidad' =>$record->get('entidad'),
            'unidad' =>$record->get('unidad'),
            'codofic' =>$record->get('codofic'),
            'codresp' =>$record->get('codresp'),
            'nomresp' =>$record->get('nomresp'),
            'cargo' =>$record->get('cargo'),
            'observ' =>$record->get('observ'),
            'ci' =>$record->get('ci'),
            'feult' =>$record->get('feult'),
            'usuar' =>$record->get('usuar'),
            'cod_exp' =>$record->get('cod_exp'),
            'api_estado' =>$record->get('api_estado'),
          ]);
        }
        return Responsables::all(); 
      }
}
