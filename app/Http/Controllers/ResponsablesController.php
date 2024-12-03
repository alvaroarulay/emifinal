<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use App\Models\Responsables;
use App\Models\Unidadadmin;
use App\Models\Actual;
use XBase\TableCreator;
use XBase\TableEditor;
use XBase\TableReader;

class ResponsablesController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $idrol = \Auth::user()->idrol;
        $unidadv = trim($request->unidad);
        $unidad = \Auth::user()->unidad;
        $a = Unidadadmin::select('descrip')->where('unidad','=',trim($unidad))->first();
        $b = Unidadadmin::select('ciudad')->where('unidad','=',trim($unidad))->first();
        $titulo = $a->descrip.' - '.$b->ciudad;
        if($idrol == 1){
            $total = Responsables::count('id');
            if($unidadv == ''){
                if ($buscar == ''){
                    $responsables = Responsables::join('unidadadmin','unidadadmin.unidad','=','resp.unidad')
                                ->join('oficina', function ($join) {
                                    $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                                    $join->on('resp.codofic', '=', 'oficina.codofic');
                                })
                                ->select('resp.id','resp.codofic','resp.codresp','resp.nomresp','resp.cargo','resp.estado',
                                'resp.ci','oficina.nomofic','resp.api_estado','resp.cod_exp')
                                ->where('resp.unidad','=',trim($unidad))
                                ->distinct()
                                ->paginate(10);
                    return [
                        'pagination' => [
                            'total'        => $responsables->total(),
                            'current_page' => $responsables->currentPage(),
                            'per_page'     => $responsables->perPage(),
                            'last_page'    => $responsables->lastPage(),
                            'from'         => $responsables->firstItem(),
                            'to'           => $responsables->lastItem(),
                        ],
                        'responsables' => $responsables,
                        'total' => $total,
                        'idrol' => $idrol,
                        'titulo' => $titulo
                    ];
    
                }
                else{
                    $responsables = Responsables::join('unidadadmin','unidadadmin.unidad','=','resp.unidad')
                                ->join('oficina', function ($join) {
                                    $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                                    $join->on('resp.codofic', '=', 'oficina.codofic');
                                })
                                ->select('resp.id','resp.codofic','resp.codresp','resp.nomresp','resp.cargo','resp.estado',
                                'resp.ci','oficina.nomofic','resp.api_estado','resp.cod_exp')
                                ->where('resp.unidad','=',trim($unidad))
                                ->distinct()
                                ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')
                                ->paginate(10);
                    return [
                        'pagination' => [
                            'total'        => $responsables->total(),
                            'current_page' => $responsables->currentPage(),
                            'per_page'     => $responsables->perPage(),
                            'last_page'    => $responsables->lastPage(),
                            'from'         => $responsables->firstItem(),
                            'to'           => $responsables->lastItem(),
                        ],
                        'responsables' => $responsables,
                        'total' => $total,
                        'idrol' => $idrol,
                        'titulo' => $titulo
                    ];
                
                }
            }else{
                if ($buscar==''){
                    $responsables = Responsables::join('unidadadmin','unidadadmin.unidad','=','resp.unidad')
                                ->join('oficina', function ($join) {
                                    $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                                    $join->on('resp.codofic', '=', 'oficina.codofic');
                                })
                                ->select('resp.id','resp.codofic','resp.codresp','resp.nomresp','resp.cargo','resp.estado',
                                'resp.ci','oficina.nomofic','resp.api_estado','resp.cod_exp')
                                ->where('resp.unidad','=',$unidadv)
                                ->distinct()
                                ->paginate(10);
                    return [
                        'pagination' => [
                            'total'        => $responsables->total(),
                            'current_page' => $responsables->currentPage(),
                            'per_page'     => $responsables->perPage(),
                            'last_page'    => $responsables->lastPage(),
                            'from'         => $responsables->firstItem(),
                            'to'           => $responsables->lastItem(),
                        ],
                        'responsables' => $responsables,
                        'total' => $total,
                        'idrol' => $idrol,
                        'titulo' => $titulo
                    ];
                
                }
                else{
                    $responsables = Responsables::join('unidadadmin','unidadadmin.unidad','=','resp.unidad')
                                ->join('oficina', function ($join) {
                                    $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                                    $join->on('resp.codofic', '=', 'oficina.codofic');
                                })
                                ->select('resp.id','resp.codofic','resp.codresp','resp.nomresp','resp.cargo','resp.estado',
                                'resp.ci','oficina.nomofic','resp.api_estado','resp.cod_exp')
                                ->where('resp.unidad','=',$unidadv)
                                ->distinct()
                                ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')
                                ->paginate(10);
                    return [
                        'pagination' => [
                            'total'        => $responsables->total(),
                            'current_page' => $responsables->currentPage(),
                            'per_page'     => $responsables->perPage(),
                            'last_page'    => $responsables->lastPage(),
                            'from'         => $responsables->firstItem(),
                            'to'           => $responsables->lastItem(),
                        ],
                        'responsables' => $responsables,
                        'total' => $total,
                        'idrol' => $idrol,
                        'titulo' => $titulo
                    ];
                }
            }
           
        }
        else{
            $total = Responsables::where('unidad','=',$unidad)->count();
             if ($buscar==''){
                $responsables = Responsables::join('unidadadmin','unidadadmin.unidad','=','resp.unidad')
                            ->join('oficina', function ($join) {
                                $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                                $join->on('resp.codofic', '=', 'oficina.codofic');
                            })
                            ->select('resp.id','resp.codofic','resp.codresp','resp.nomresp','resp.cargo','resp.estado',
                            'resp.ci','oficina.nomofic','resp.api_estado','resp.cod_exp')
                            ->where('resp.unidad','=',$unidad)
                            ->distinct()
                ->paginate(10);
                return [
                    'pagination' => [
                        'total'        => $responsables->total(),
                        'current_page' => $responsables->currentPage(),
                        'per_page'     => $responsables->perPage(),
                        'last_page'    => $responsables->lastPage(),
                        'from'         => $responsables->firstItem(),
                        'to'           => $responsables->lastItem(),
                    ],
                    'responsables' => $responsables,
                    'total' => $total,
                    'idrol' => $idrol,
                    'titulo' => $titulo
                ];

            }
            else{
                $responsables = Responsables::join('unidadadmin','unidadadmin.unidad','=','resp.unidad')
                            ->join('oficina', function ($join) {
                                $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                                $join->on('resp.codofic', '=', 'oficina.codofic');
                            })
                            ->select('resp.id','resp.codofic','resp.codresp','resp.nomresp','resp.cargo','resp.estado',
                            'resp.ci','oficina.nomofic','resp.api_estado','resp.cod_exp')
                            ->where('resp.unidad','=',$unidad)
                            ->distinct()
                ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')
                ->paginate(10);
                return [
                    'pagination' => [
                        'total'        => $responsables->total(),
                        'current_page' => $responsables->currentPage(),
                        'per_page'     => $responsables->perPage(),
                        'last_page'    => $responsables->lastPage(),
                        'from'         => $responsables->firstItem(),
                        'to'           => $responsables->lastItem(),
                    ],
                    'responsables' => $responsables,
                    'total' => $total,
                    'idrol' => $idrol,
                    'titulo' => $titulo
                ];

            }
        }
        
    }
    public function buscarRespActivo(Request $request){
        
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $unidad = $request->unidad;
        
        $total = Responsables::where('unidad','=',$unidad)->get();
        $idrol = \Auth::user()->idrol;
        if ($buscar==''){
            $responsables = Responsables::join('oficina','resp.codofic','=','oficina.codofic')
            ->select('resp.id','resp.codofic','resp.codresp','resp.nomresp','resp.cargo','resp.estado',
            'resp.ci','oficina.nomofic','resp.api_estado','resp.cod_exp')
            ->distinct()
            ->where('resp.unidad','=',$unidad)->paginate(10);
        }
        else{
            $responsables = Responsables::join('oficina','resp.codofic','=','oficina.codofic')
            ->select('resp.id','resp.codofic','resp.codresp','resp.nomresp','resp.cargo','resp.estado',
            'resp.ci','oficina.nomofic','resp.api_estado','resp.cod_exp')
            ->distinct()
            ->where('resp.unidad','=',$unidad)
            ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')
            ->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $responsables->total(),
                'current_page' => $responsables->currentPage(),
                'per_page'     => $responsables->perPage(),
                'last_page'    => $responsables->lastPage(),
                'from'         => $responsables->firstItem(),
                'to'           => $responsables->lastItem(),
            ],
            'responsables' => $responsables,
            'total' => $total->count(),
            'idrol' => $idrol
        ];
    }
    public function store(Request $request)
    {
        $unidad = $request->unidad;
        $fecha = Carbon::now()->format('Ymd');

   try { 
        
            $codofic = Responsables::where('codofic','=',$request->codofic)->where('unidad','=',$unidad)->count();
            $responsable = new Responsables();
            $responsable->entidad='170';
            $responsable->unidad=$request->unidad;
            $responsable->codofic = $request->codofic;
            $responsable->codresp = $codofic + 1;
            $responsable->nomresp = $request->nomresp;
            $responsable->cargo = $request->cargo;
            $responsable->observ = $request->observ;
            $responsable->ci = $request->ci;
            $responsable->feult = $fecha;
            $responsable->usuar = \Auth::user()->username;
            $responsable->cod_exp = $request->expedido;
            $responsable->api_estado = 1;
            $responsable->estado = $request->estado;
            $responsable->custodio = 0;
            $responsable->save();

            return response()->json(['message' => 'Datos Guardados Correctamente!!!']);   
        } catch (Exception $e) {
            return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $responsable = Responsables::findOrFail($request->id);
        $responsable->nomresp = $request->nomresp;
        $responsable->cargo = $request->cargo;
        $responsable->ci = $request->ci;
        $responsable->cod_exp = $request->cod_exp;
        $responsable->api_estado = $request->api_estado;
        $responsable->save();
        
        return response()->json(['message' => 'Datos Actualizados Correctamente!!!']);
    }
    public function actualizarDatos(){
        $table = new TableReader(public_path('vsiaf/dbfs/RESP.DBF'),['encoding' => 'cp1252']);
        $responsables=Responsables::count();
        $contador = 0;
      
        while ($record = $table->nextRecord()) {
            $contador ++;
            if($responsables < $contador){
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
        }
        $table->close();
        if($responsables == $contador){
            return response()->json(['message' => 'No hay Registros Nuevos!!!']);
        } 
        else{
            return response()->json(['message' => 'Datos Actualizados Correctamente!!!']);
        }
      }
    public function buscarResponsable(Request $request){

        //if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $responsable = Responsables::join('oficina','resp.codofic','=','oficina.codofic')
        ->distinct()
        ->where('resp.unidad','=',$request->unidad)
        ->where('resp.ci','=', $filtro)
        ->select('resp.id','resp.nomresp','resp.cargo','oficina.nomofic','resp.api_estado','resp.codresp','resp.codofic')->first();
        return response()->json(['responsable' => $responsable]);
    }
    public function buscarRespxcodigo(Request $request){

        //if (!$request->ajax()) return redirect('/');

        $codofic = $request->codofic;
        $codresp = $request->codresp;
        $responsable = Responsables::join('oficina','resp.codofic','=','oficina.codofic')
        ->where('resp.codresp','=', $codresp)
        ->where('resp.codofic','=', $codofic)
        ->select('resp.id','resp.nomresp','resp.cargo','oficina.nomofic','resp.api_estado','resp.codresp','resp.codofic')->first();
        return response()->json(['responsable' => $responsable]);
    }
    public function listarResponsable(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        

        return ['articulos' => $articulos];
    }
    public function delete(Request $request){
        //echo (intval($request->codresp));
        $activo = Actual::where('codresp','=',$request->codresp)->where('codofic','=',$request->codofic)->get();
        $activo = $activo->count();
        if($activo==0){
            $res=Responsables::where('id',$request->id)->delete();

            $table = new TableEditor(public_path('vsiaf/dbfs/RESP.DBF'),['encoding' => 'cp1252']);

            while ($record = $table->nextRecord()) {
                if ($record->get('codofic')==$request->codofic && $record->get('codresp')==$request->codresp) {
                    $table->deleteRecord(); //mark record deleted
                }    
            }

            $table->pack()->save()->close();

            return response()->json(['message' => 'Responsable Eliminado Exitosamente !!!']);
        }else{
            return response()->json(['message' => 'El Usuario tiene '.$activo.' Activos asignados, no se puede Eliminar!!!']);
        }
        
    }
    public function repResponsables(){
        $idrol = \Auth::user()->idrol;
        if($idrol == 1){
            $responsable = Responsables::join('unidadadmin','unidadadmin.unidad','=','resp.unidad')
                                ->join('oficina', function ($join) {
                                    $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                                    $join->on('resp.codofic', '=', 'oficina.codofic');
                                })
                                    ->select('resp.nomresp','resp.ci','oficina.nomofic','resp.cargo',
                                    'resp.observ')->distinct()->get();
        }
        else
        {
        $responsable = Responsables::join('oficina','resp.codofic','=','oficina.codofic')
                                    ->select('resp.nomresp','resp.ci','oficina.nomofic','resp.cargo',
                                    'resp.observ')
                                    ->where('oficina.unidad','=',\Auth::user()->unidad)
                                    ->where('resp.unidad','=',\Auth::user()->unidad)
                                    ->distinct()->get();
                                }
        return response()->json(['responsable' => $responsable]);                      
    }
    public function listarporOficina(Request $request){
        $codofic = $request->codofic;
        $unidad = $request->unidad;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $responsables = Responsables::where('resp.codofic','=',$codofic)->where('resp.unidad','=',$unidad)
            ->get();
             return [
                'responsables' => $responsables,
                'total'=>$responsables->count()
                ];
        }else{
            $responsables = Responsables::where('resp.codofic','=',$codofic)->where('resp.unidad','=',$unidad)
            ->where('resp.'.$criterio, 'like', '%'. $buscar . '%')
            ->get();
             return [
                'responsables' => $responsables,
                'total'=>$responsables->count()
                ];
        }
    }
    
}
