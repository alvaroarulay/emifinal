<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class Unidadadmin extends Model
{
    use HasFactory;
    protected $table = "unidadadmin";
    protected $fillable = [
        'unidad',
        'descrip',
        'ciudad',
        'estadouni', 
        'estado', 
    ];
    public function obtenerUnidad()
    {
        return Unidadadmin::all();
    }
    public function obtenerUnidadPorId($id)
    {
        return Unidadadmin::find($id);
    }
    public function actualizarDatos(){
        $unidades=Unidadadmin::all();
        foreach ($unidades as $data) {
            $data->delete();
        }
        $table = new TableReader('C:/vsiaf/dbfs/unidadadmin.dbf',['encoding' => 'cp1251']);
        while ($record = $table->nextRecord()) {
            DB::table('unidadadmin')->insert([
            'entidad' =>$record->get('entidad'),
            'unidad' =>$record->get('unidad'),
            'descrip' => $record->get('descrip'),
            'ciudad' => $record->get('ciudad'),
            'estadouni' => $record->get('estadouni'),
            'estado' => false,
          ]);
        return Unidadadmin::all(); 
      }
    }
}
