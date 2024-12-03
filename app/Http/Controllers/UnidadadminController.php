<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidadadmin;
use App\Models\Responsables;

class UnidadadminController extends Controller
{
    public function index()
    {
       
        $unidad = Unidadadmin::All();
        return [
            'unidad'=>$unidad
        ];
    }
    public function update(Request $request){
      
        try {
            $codcont = Unidadadmin::find($request->id);
            $codcont->unidad=$request->unidad;
            $codcont->descrip=$request->descripcion;
            $codcont->estado=$request->estado;
            $codcont->save();
         } catch (Exception $e) {
             return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
         }
         
         return response()->json(['message' => 'Datos Actualizados Correctamente!!!']);
    }
    public function selectUnidad(){
        $idrol = \Auth::user()->idrol;
        $unidad = \Auth::user()->unidad;
        $a = Unidadadmin::select('descrip')->where('unidad','=',$unidad)->first();
        $b = Unidadadmin::select('ciudad')->where('unidad','=',$unidad)->first();
        $titulo = $a->descrip.' - '.$b->ciudad;
        $unidad1 = Unidadadmin::select('id','unidad','descrip')->where('estado','=',1)->get();
        return [
            'unidad'=>$unidad1,
            'titulo' => $titulo,
            'idrol' => $idrol,
            'descripcion' => $a->descrip,
            'idunidad' => $unidad
        ];
    }
}
