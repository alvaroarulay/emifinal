<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Bajas;

class BajasController extends Controller
{
    public function index(Request $request)
    {   
           if (\Auth::check()) {
            $buscar = $request->buscar;
            $criterio = $request->criterio;
            $total = Bajas::count('id');
            if ($buscar==''){
            $bajas = Bajas::join('codcont','bajas.codcont','=','codcont.codcont')
            ->join('auxiliar',function ($join) {
                $join->on('bajas.codaux', '=', 'auxiliar.codaux');
                    $join->on('bajas.unidad', '=', 'auxiliar.unidad');
                    $join->on('bajas.codcont', '=', 'auxiliar.codcont');
            })
            ->join('oficina',function ($join) {
                $join->on('bajas.codofic', '=', 'oficina.codofic');
                    $join->on('bajas.unidad', '=', 'oficina.unidad');
            })
            ->join('resp',function ($join) {
                $join->on('bajas.codresp', '=', 'resp.codresp');
                    $join->on('bajas.codofic', '=', 'resp.codofic');
                    $join->on('bajas.unidad', '=', 'resp.unidad');
            })
            ->select('bajas.id','bajas.unidad','bajas.codigo','codcont.nombre',
            'auxiliar.nomaux','bajas.vidautil','oficina.nomofic','resp.nomresp',
            'bajas.descrip','bajas.motivo','bajas.resolucion',
            'bajas.dia','bajas.mes','bajas.año',
            'bajas.d_baja','bajas.m_baja','bajas.a_baja','bajas.costo')
            ->distinct('bajas.id')->paginate(5);
            }
            else{
                $bajas = Bajas::join('codcont','bajas.codcont','=','codcont.codcont')
                ->join('auxiliar',function ($join) {
                    $join->on('bajas.codaux', '=', 'auxiliar.codaux');
                        $join->on('bajas.unidad', '=', 'auxiliar.unidad');
                        $join->on('bajas.codcont', '=', 'auxiliar.codcont');
                })
                ->join('oficina',function ($join) {
                    $join->on('bajas.codofic', '=', 'oficina.codofic');
                        $join->on('bajas.unidad', '=', 'oficina.unidad');
                })
                ->join('resp',function ($join) {
                    $join->on('bajas.codresp', '=', 'resp.codresp');
                        $join->on('bajas.codofic', '=', 'resp.codofic');
                        $join->on('bajas.unidad', '=', 'resp.unidad');
                })
                ->select('bajas.id','bajas.unidad','bajas.codigo','codcont.nombre',
                'auxiliar.nomaux','bajas.vidautil','oficina.nomofic','resp.nomresp',
                'bajas.descrip','bajas.motivo','bajas.resolucion',
                'bajas.dia','bajas.mes','bajas.año',
                'bajas.d_baja','bajas.m_baja','bajas.a_baja','bajas.costo')
                ->where('bajas.'.$criterio, 'like', '%'. $buscar . '%')->paginate(5);           
            }
            return [
            'pagination' => [
                'total'        => $bajas->total(),
                'current_page' => $bajas->currentPage(),
                'per_page'     => $bajas->perPage(),
                'last_page'    => $bajas->lastPage(),
                'from'         => $bajas->firstItem(),
                'to'           => $bajas->lastItem(),
            ],
            'bajas'=>$bajas,
            'total'=>$total
            ];
        } else {
            $bajas = 0;
            return ['bajas'=>$bajas, 'pagination'=>0];
        }
        
    }
    public function auxiliar(Request $request){
        $codcont = $request->codcont;
        $codaux = $request->codaux;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $bajas = Bajas::select('id','codigo','descrip')
            ->where('codcont','=',$codcont)->where('codaux','=',$codaux)->get();
            return response()->json(['bajas'=>$bajas,'totalbajas'=>$bajas->count()]);
        }else{
            $bajas = Bajas::where('codcont','=',$codcont)
            ->where('codaux','=',$codaux)
            ->where('bajas.'.$criterio, 'like', '%'. $buscar . '%')
            ->get();
            return response()->json(['bajas'=>$bajas,'totalbajas'=>$bajas->count()]);
        }
    }
}
