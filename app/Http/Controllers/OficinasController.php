<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Oficinas;
use App\Models\Actual;
use App\Models\Responsables;
use App\Models\Unidadadmin;
use XBase\TableCreator;
use XBase\TableEditor;
use XBase\TableReader;

class OficinasController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $unidad = $request->unidad;

        if ($buscar==''){
            $oficinas = Oficinas::select('oficina.id','oficina.codofic','oficina.nomofic','oficina.api_estado','oficina.observ')
            ->distinct()
            ->where('oficina.unidad','=',$unidad)
            ->paginate(10);
        }
        else{
            $oficinas = Oficinas::select('oficina.id','oficina.codofic','oficina.nomofic','oficina.api_estado','oficina.observ')
            ->distinct()
            ->where('oficina.unidad','=',$unidad)
            ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')
            ->paginate(10);
        }
        return [
            'pagination' => [
                'total'        => $oficinas->total(),
                'current_page' => $oficinas->currentPage(),
                'per_page'     => $oficinas->perPage(),
                'last_page'    => $oficinas->lastPage(),
                'from'         => $oficinas->firstItem(),
                'to'           => $oficinas->lastItem(),
            ],
            'oficinas' => $oficinas
        ];
    }
    public function store(Request $request){
        $unidad = Oficinas::where('unidad','=',$request->unidad)->count();
        try {
            //CREAR OFICINA
            $oficina = new Oficinas();
            $oficina->entidad = "170";
            $oficina->unidad = $request->unidad;
            $oficina->codofic = $unidad + 1;
            $oficina->nomofic = $request->nomofic;
            $oficina->observ = $request->observ;
            $oficina->feult = now();
            $oficina->usuar = auth()->user()->name;
            $oficina->api_estado = $request->estado;
            $oficina->save();
            return response()->json(['message' => 'Datos guardados correctamente!!!']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
        }
    }
    public function update(Request $request){
        try {
            $oficina = Oficinas::findOrFail($request->id);
            $oficina->nomofic = $request->nomofic;
            $oficina->observ = $request->observ;
            $oficina->usuar = auth()->user()->name;
            $oficina->api_estado = $request->estado;
            $oficina->save();
        } catch (Exception $e) {
        return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
        }

        return response()->json(['message' => 'Datos Actualizados Correctamente!!!']);
    }
    public function responsables(Request $request){
        if(isset($request->id)){
            $unidad = Unidadadmin::where('estado','=','1')->first();
            $responsables= Responsables::where([
                ['codofic', '=', $request->id],
                ['unidad', '=', $unidad->unidad],
            ])->get();
            $oficinas = Oficinas::where('codofic','=', $request->id)->first();
            return response()->json(
                [
                    'responsables'=>$responsables,
                    'oficinas'=>$oficinas,
                    'unidad' => $unidad,
                    'success' => true
                ]
                );
        }else
        {
            return response()->json(
                [
                   'success' => false,
                ]
                );
        }
    }
    public function responsableActuales(Request $request){
        if(isset($request->id)){
            $unidad = Unidadadmin::where('estado','=','1')->first();
            $actuales = Actual::where('unidad','=',$unidad->unidad)->get();
            $responsables= Responsables::where([
                ['codofic', '=', $request->id],
                ['unidad', '=', $unidad->unidad],
            ])->get();
            $oficinas = Oficinas::where('codofic','=', $request->id)->first();
            return response()->json(
                [
                    'responsables'=>$responsables,
                    'oficinas'=>$oficinas,
                    'unidad' => $unidad,
                    'success' => true
                ]
                );
        }else
        {
            return response()->json(
                [
                   'success' => false,
                ]
                );
        }
    }
    public function buscarOficina(Request $request){

        //if (!$request->ajax()) return redirect('/');
        $unidad = $request->unidad;
        $filtro = $request->filtro;
        $oficina = Oficinas::where('unidad','=',$unidad)->where('codofic','=', $filtro)->first();
        return response()->json(['oficina' => $oficina]);
    }
    public function actualizarDatos(){
        $table = new TableReader(public_path('vsiaf/dbfs/OFICINA.DBF'),['encoding' => 'cp1252']);
        $oficinas=Oficinas::count();
        $contador = 0;

        while ($record = $table->nextRecord()) {
        $contador ++;
        if($oficinas < $contador){
            DB::table('oficina')->insert([
                'entidad' => $record->get('entidad'),
                'unidad' => $record->get('unidad'),
                'codofic' => $record->get('codofic'),
                'nomofic' => $record->get('nomofic'),
                'feult' => $record->get('feult'),
                'usuar' => $record->get('usuar'),
                'api_estado' => $record->get('api_estado'),
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
            }
        }
        $table->close();

        if($oficinas == $contador){
            return response()->json(['message' => 'No hay Registros Nuevos!!!']);
            } 
        else{
            return response()->json(['message' => 'Datos Actualizados Correctamente!!!']);
            }
    }
    public function activar(Request $request){
        try {

            $oficina = Oficinas::findOrFail($request->id);
            $oficina->api_estado = 1;
            $oficina->save();

            return response()->json(['message' => 'Oficina activada!!!','id'=>$oficina->id]);

        } catch (Exception $e) {

            return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
        }
    }
    public function desactivar(Request $request){
        try {

            $oficina = Oficinas::findOrFail($request->id);
            $oficina->api_estado = 0;
            $oficina->save();

            return response()->json(['message' => 'Oficina desactivada!!!','id'=>$oficina->id]);

        } catch (Exception $e) {

            return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
        }
    }
}
