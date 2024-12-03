<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Actual;
use App\Models\CodigoContable;
use App\Models\Auxiliares;
use App\Models\Oficinas;
use App\Models\Responsables;
use App\Models\User;

class EscritorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $idrol = \Auth::user()->idrol;
       if($idrol==1){
            $activos = Actual::count();
            $auxiliares = Auxiliares::count();
            $oficinas = Oficinas::count();
            $responsables = Responsables::count();
            $users = User::count();
       }
       else{
            $activos = Actual::where('unidad','=',\Auth::user()->unidad)->count();
            $auxiliares = Auxiliares::where('unidad','=',\Auth::user()->unidad)->count();
            $oficinas = Oficinas::where('unidad','=',\Auth::user()->unidad)->count();
            $responsables = Responsables::where('unidad','=',\Auth::user()->unidad)->count();
            $users = User::count();
        }
     
       return response()->json(['activos'=>$activos,'auxiliares'=>$auxiliares,'oficinas'=>$oficinas,'responsables'=>$responsables, 'users'=>$users]);
    }

    public function grafica1()
    {
        $idrol = \Auth::user()->idrol;
        if($idrol==1){
            $estados = Actual::join('estado','estado.id','=','actual.codestado')->select('estado.nomestado',DB::raw('count(*) as valor'))->groupBy('actual.codestado')->get();
        }
        else{
                $estados = Actual::join('estado','estado.id','=','actual.codestado')->select('estado.nomestado',DB::raw('count(*) as valor'))->where('unidad','=',\Auth::user()->unidad)->groupBy('actual.codestado')->get();
            }
        return response()->json(['estados'=>$estados]);
    }

    public function grafica2()
    {
        $idrol = \Auth::user()->idrol;
        
        if($idrol==1){
            $gcontable = Actual::join('codcont','actual.codcont', '=', 'codcont.codcont')
            ->select('codcont.nombre',DB::raw('count(*) as valor'))
            ->groupBy('codcont.nombre')
            ->orderBy('valor', 'DESC')->take(10)->get();
            return response()->json(['gcontable'=>$gcontable]);
        }
        else{
            $gcontable = Actual::join('codcont','actual.codcont', '=', 'codcont.codcont')
            ->select('codcont.nombre',DB::raw('count(*) as valor'))
            ->where('unidad','=',\Auth::user()->unidad)
            ->groupBy('codcont.nombre')
            ->orderBy('valor', 'DESC')->take(10)->get();
            return response()->json(['gcontable'=>$gcontable]);
        }
        
    }
}
