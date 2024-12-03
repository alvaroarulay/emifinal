<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Actual;
use App\Models\CodigoContable;
use App\Models\Auxiliares;
use App\Models\Oficinas;
use App\Models\Responsables;
use App\Models\Unidadadmin;
use App\Models\Logs;
use App\Models\Asignaciones;
use App\Models\actaAsignacion;
use App\Models\actaDevolucion;
use XBase\TableCreator;
use XBase\TableEditor;
use XBase\TableReader;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Jenssegers\Date\Date;

class ActualController extends Controller
{
    public function index(Request $request)
    {   
        
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $unidadv = $request->unidad;
        $idrol = \Auth::user()->idrol;
        $unidad = \Auth::user()->unidad;
        if($idrol == 1){
            if($unidadv == ''){
                //usar unidad
                $a = Unidadadmin::select('descrip')->where('unidad','=',$unidad)->first();
                $b = Unidadadmin::select('ciudad')->where('unidad','=',$unidad)->first();
                $titulo = $a->descrip.' - '.$b->ciudad;
                $total = Actual::where('unidad','=',$unidad)->get();

                if($buscar == ''){
                    $actuales = Actual::join('unidadadmin','actual.unidad','=','unidadadmin.unidad')
                    ->join('oficina', function ($join) {
                        $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                        $join->on('actual.codofic', '=', 'oficina.codofic');
                    })
                    ->join('resp', function ($join) {
                                $join->on('unidadadmin.unidad', '=', 'resp.unidad');
                                $join->on('resp.codofic', '=', 'oficina.codofic');
                                $join->on('actual.codresp', '=', 'resp.codresp');
                                $join->on('actual.codofic', '=', 'resp.codofic');
                            })
                    ->join('codcont','actual.codcont','=','codcont.codcont')
                    ->join('auxiliar', function ($join) {
                        $join->on('unidadadmin.unidad', '=', 'auxiliar.unidad');
                        $join->on('auxiliar.codcont', '=', 'codcont.codcont');
                        $join->on('actual.codaux', '=', 'auxiliar.codaux');
                        $join->on('actual.codcont', '=', 'auxiliar.codcont');
                    })
                    ->select('actual.id', 'actual.unidad', 'actual.codigo', 'codcont.nombre',
                            'auxiliar.nomaux', 'actual.vidautil', 'oficina.nomofic', 'resp.nomresp',
                            'actual.descripcion', 'actual.codestado', 'actual.estadoasignacion',
                            'actual.dia', 'actual.mes', 'actual.año', 'actual.costo', 'actual.costo_ant',
                            'actual.cod_rube', 'actual.codigosec', 'actual.observ', 'actual.codcont', 
                            'actual.codaux')
                    ->where('unidadadmin.unidad','=',$unidad)
                    ->distinct()
                    ->paginate(10);
                    return [
                        'pagination' => [
                            'total'        => $actuales->total(),
                            'current_page' => $actuales->currentPage(),
                            'per_page'     => $actuales->perPage(),
                            'last_page'    => $actuales->lastPage(),
                            'from'         => $actuales->firstItem(),
                            'to'           => $actuales->lastItem(),
                        ],
                        'actuales'=>$actuales,
                        'total'=>$total->count(),
                        'idrol'=>$idrol,
                        'titulo'=>$titulo
                        ];
                }else{
                    $actuales = Actual::join('unidadadmin','actual.unidad','=','unidadadmin.unidad')
                    ->join('oficina', function ($join) {
                        $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                        $join->on('actual.codofic', '=', 'oficina.codofic');
                    })
                    ->join('resp', function ($join) {
                                $join->on('unidadadmin.unidad', '=', 'resp.unidad');
                                $join->on('resp.codofic', '=', 'oficina.codofic');
                                $join->on('actual.codresp', '=', 'resp.codresp');
                                $join->on('actual.codofic', '=', 'resp.codofic');
                            })
                    ->join('codcont','actual.codcont','=','codcont.codcont')
                    ->join('auxiliar', function ($join) {
                        $join->on('unidadadmin.unidad', '=', 'auxiliar.unidad');
                        $join->on('auxiliar.codcont', '=', 'codcont.codcont');
                        $join->on('actual.codaux', '=', 'auxiliar.codaux');
                        $join->on('actual.codcont', '=', 'auxiliar.codcont');
                    })
                    ->select('actual.id', 'actual.unidad', 'actual.codigo', 'codcont.nombre',
                            'auxiliar.nomaux', 'actual.vidautil', 'oficina.nomofic', 'resp.nomresp',
                            'actual.descripcion', 'actual.codestado', 'actual.estadoasignacion',
                            'actual.dia', 'actual.mes', 'actual.año', 'actual.costo', 'actual.costo_ant',
                            'actual.cod_rube', 'actual.codigosec', 'actual.observ', 'actual.codcont', 
                            'actual.codaux')
                    ->where('unidadadmin.unidad','=',$unidad)
                    ->where('actual.'.$criterio, 'like', '%'. $buscar . '%')
                    ->distinct()
                    ->paginate(10);
                    return [
                        'pagination' => [
                            'total'        => $actuales->total(),
                            'current_page' => $actuales->currentPage(),
                            'per_page'     => $actuales->perPage(),
                            'last_page'    => $actuales->lastPage(),
                            'from'         => $actuales->firstItem(),
                            'to'           => $actuales->lastItem(),
                        ],
                        'actuales'=>$actuales,
                        'total'=>$total->count(),
                        'idrol'=>$idrol,
                        'titulo'=>$titulo
                        ];
                }
            }else{
                // usar unidadv
                $a = Unidadadmin::select('descrip')->where('unidad','=',$unidadv)->first();
                $b = Unidadadmin::select('ciudad')->where('unidad','=',$unidadv)->first();
                $titulo = $a->descrip.' - '.$b->ciudad;
                $total = Actual::where('unidad','=',$unidadv)->get();
                if($buscar == ''){
                    $actuales = Actual::join('unidadadmin','actual.unidad','=','unidadadmin.unidad')
                                    ->join('oficina', function ($join) {
                                        $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                                        $join->on('actual.codofic', '=', 'oficina.codofic');
                                    })
                                    ->join('resp', function ($join) {
                                                $join->on('unidadadmin.unidad', '=', 'resp.unidad');
                                                $join->on('resp.codofic', '=', 'oficina.codofic');
                                                $join->on('actual.codresp', '=', 'resp.codresp');
                                                $join->on('actual.codofic', '=', 'resp.codofic');
                                            })
                                    ->join('codcont','actual.codcont','=','codcont.codcont')
                                    ->join('auxiliar', function ($join) {
                                        $join->on('unidadadmin.unidad', '=', 'auxiliar.unidad');
                                        $join->on('auxiliar.codcont', '=', 'codcont.codcont');
                                        $join->on('actual.codaux', '=', 'auxiliar.codaux');
                                        $join->on('actual.codcont', '=', 'auxiliar.codcont');
                                    })
                                    ->select('actual.id', 'actual.unidad', 'actual.codigo', 'codcont.nombre',
                                            'auxiliar.nomaux', 'actual.vidautil', 'oficina.nomofic', 'resp.nomresp',
                                            'actual.descripcion', 'actual.codestado', 'actual.estadoasignacion',
                                            'actual.dia', 'actual.mes', 'actual.año', 'actual.costo', 'actual.costo_ant',
                                            'actual.cod_rube', 'actual.codigosec', 'actual.observ', 'actual.codcont', 
                                            'actual.codaux')
                                    ->where('unidadadmin.unidad','=',$unidadv)
                                    ->distinct()
                                    ->paginate(10);
                    return [
                        'pagination' => [
                            'total'        => $actuales->total(),
                            'current_page' => $actuales->currentPage(),
                            'per_page'     => $actuales->perPage(),
                            'last_page'    => $actuales->lastPage(),
                            'from'         => $actuales->firstItem(),
                            'to'           => $actuales->lastItem(),
                        ],
                        'actuales'=>$actuales,
                        'total'=>$total->count(),
                        'titulo'=>$titulo,
                        'idrol'=>$idrol
                        ];
                }else{
                    $actuales = Actual::join('unidadadmin','actual.unidad','=','unidadadmin.unidad')
                                    ->join('oficina', function ($join) {
                                        $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                                        $join->on('actual.codofic', '=', 'oficina.codofic');
                                    })
                                    ->join('resp', function ($join) {
                                                $join->on('unidadadmin.unidad', '=', 'resp.unidad');
                                                $join->on('resp.codofic', '=', 'oficina.codofic');
                                                $join->on('actual.codresp', '=', 'resp.codresp');
                                                $join->on('actual.codofic', '=', 'resp.codofic');
                                            })
                                    ->join('codcont','actual.codcont','=','codcont.codcont')
                                    ->join('auxiliar', function ($join) {
                                        $join->on('unidadadmin.unidad', '=', 'auxiliar.unidad');
                                        $join->on('auxiliar.codcont', '=', 'codcont.codcont');
                                        $join->on('actual.codaux', '=', 'auxiliar.codaux');
                                        $join->on('actual.codcont', '=', 'auxiliar.codcont');
                                    })
                                    ->select('actual.id', 'actual.unidad', 'actual.codigo', 'codcont.nombre',
                                            'auxiliar.nomaux', 'actual.vidautil', 'oficina.nomofic', 'resp.nomresp',
                                            'actual.descripcion', 'actual.codestado', 'actual.estadoasignacion',
                                            'actual.dia', 'actual.mes', 'actual.año', 'actual.costo', 'actual.costo_ant',
                                            'actual.cod_rube', 'actual.codigosec', 'actual.observ', 'actual.codcont', 
                                            'actual.codaux')
                                    ->where('unidadadmin.unidad','=',$unidadv)
                                    ->where('actual.'.$criterio, 'like', '%'. $buscar . '%')
                                    ->distinct()
                                    ->paginate(10);
                return [
                    'pagination' => [
                        'total'        => $actuales->total(),
                        'current_page' => $actuales->currentPage(),
                        'per_page'     => $actuales->perPage(),
                        'last_page'    => $actuales->lastPage(),
                        'from'         => $actuales->firstItem(),
                        'to'           => $actuales->lastItem(),
                    ],
                    'actuales'=>$actuales,
                    'total'=>$total->count(),
                    'titulo'=>$titulo,
                    'idrol'=>$idrol
                    ];
                }
            }
        }else{
            $a = Unidadadmin::select('descrip')->where('unidad','=',$unidad)->first();
            $b = Unidadadmin::select('ciudad')->where('unidad','=',$unidad)->first();
            $titulo = $a->descrip.' - '.$b->ciudad;
            $total = Actual::where('unidad','=',$unidad)->get();
            if($buscar == '')
            {
                $actuales = Actual::join('unidadadmin','actual.unidad','=','unidadadmin.unidad')
                                ->join('oficina', function ($join) {
                                    $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                                    $join->on('actual.codofic', '=', 'oficina.codofic');
                                })
                                ->join('resp', function ($join) {
                                            $join->on('unidadadmin.unidad', '=', 'resp.unidad');
                                            $join->on('resp.codofic', '=', 'oficina.codofic');
                                            $join->on('actual.codresp', '=', 'resp.codresp');
                                            $join->on('actual.codofic', '=', 'resp.codofic');
                                        })
                                ->join('codcont','actual.codcont','=','codcont.codcont')
                                ->join('auxiliar', function ($join) {
                                    $join->on('unidadadmin.unidad', '=', 'auxiliar.unidad');
                                    $join->on('auxiliar.codcont', '=', 'codcont.codcont');
                                    $join->on('actual.codaux', '=', 'auxiliar.codaux');
                                    $join->on('actual.codcont', '=', 'auxiliar.codcont');
                                })
                                ->select('actual.id', 'actual.unidad', 'actual.codigo', 'codcont.nombre',
                                        'auxiliar.nomaux', 'actual.vidautil', 'oficina.nomofic', 'resp.nomresp',
                                        'actual.descripcion', 'actual.codestado', 'actual.estadoasignacion',
                                        'actual.dia', 'actual.mes', 'actual.año', 'actual.costo', 'actual.costo_ant',
                                        'actual.cod_rube', 'actual.codigosec', 'actual.observ', 'actual.codcont', 
                                        'actual.codaux')
                                ->where('unidadadmin.unidad','=',$unidad)
                                ->distinct()
                                ->paginate(10);
                return [
                    'pagination' => [
                        'total'        => $actuales->total(),
                        'current_page' => $actuales->currentPage(),
                        'per_page'     => $actuales->perPage(),
                        'last_page'    => $actuales->lastPage(),
                        'from'         => $actuales->firstItem(),
                        'to'           => $actuales->lastItem(),
                    ],
                    'actuales'=>$actuales,
                    'total'=>$total->count(),
                    'titulo'=>$titulo,
                    'idrol'=>$idrol
                    ];
            }
            else
            {
                $actuales = Actual::join('unidadadmin','actual.unidad','=','unidadadmin.unidad')
                                    ->join('oficina', function ($join) {
                                        $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                                        $join->on('actual.codofic', '=', 'oficina.codofic');
                                    })
                                    ->join('resp', function ($join) {
                                                $join->on('unidadadmin.unidad', '=', 'resp.unidad');
                                                $join->on('resp.codofic', '=', 'oficina.codofic');
                                                $join->on('actual.codresp', '=', 'resp.codresp');
                                                $join->on('actual.codofic', '=', 'resp.codofic');
                                            })
                                    ->join('codcont','actual.codcont','=','codcont.codcont')
                                    ->join('auxiliar', function ($join) {
                                        $join->on('unidadadmin.unidad', '=', 'auxiliar.unidad');
                                        $join->on('auxiliar.codcont', '=', 'codcont.codcont');
                                        $join->on('actual.codaux', '=', 'auxiliar.codaux');
                                        $join->on('actual.codcont', '=', 'auxiliar.codcont');
                                    })
                                    ->select('actual.id', 'actual.unidad', 'actual.codigo', 'codcont.nombre',
                                            'auxiliar.nomaux', 'actual.vidautil', 'oficina.nomofic', 'resp.nomresp',
                                            'actual.descripcion', 'actual.codestado', 'actual.estadoasignacion',
                                            'actual.dia', 'actual.mes', 'actual.año', 'actual.costo', 'actual.costo_ant',
                                            'actual.cod_rube', 'actual.codigosec', 'actual.observ', 'actual.codcont', 
                                            'actual.codaux')
                                    ->where('unidadadmin.unidad','=',$unidad)
                                    ->where('actual.'.$criterio, 'like', '%'. $buscar . '%')
                                    ->distinct()
                                    ->paginate(10);
                return [
                    'pagination' => [
                        'total'        => $actuales->total(),
                        'current_page' => $actuales->currentPage(),
                        'per_page'     => $actuales->perPage(),
                        'last_page'    => $actuales->lastPage(),
                        'from'         => $actuales->firstItem(),
                        'to'           => $actuales->lastItem(),
                    ],
                    'actuales'=>$actuales,
                    'total'=>$total->count(),
                    'titulo'=>$titulo,
                    'idrol'=>$idrol
                    ];
            }
        }
    }
    public function show($id)
    {
        $actual = Actual::find($id);
        $responsable = Responsables::select('nomresp')->where('codresp','=',$actual->codresp)->where('codofic','=',$actual->codofic)->first();
        $codcont = CodigoContable::select('nombre')->where('codcont','=',$actual->codcont)->first();
        $auxiliar = Auxiliares::select('nomaux')->where('codaux','=',$actual->codaux)->first();
        $oficina = Oficinas::select('nomofic')->where('codofic','=',$actual->codofic)->first();
        return view('actuales.ver', ['actual' => $actual,'responsable'=>$responsable,'codcont'=>$codcont,'auxiliar'=>$auxiliar,'oficina'=>$oficina]);
    }
    public function update(Request $request)
    {
        $articuloant = Actual::where('id','=',$request->id)->first();
        $codActualizar = $request->id;
        $contcodcont = $articuloant->codcont != $request->codcont ? true : false;
        $contcodaux = $articuloant->codaux != $request->codaux ? true : false;
        $contdescripcion = $articuloant->descripcion != $request->descripcion ? true : false;
        $contobserv = $articuloant->observ != $request->observacion ? true : false;
        $contcodestado = $articuloant->codestado != $request->estado ? true : false;
        $contcodsec = $articuloant->codigosec != $request->codsec ? true : false;

        $articulo = Actual::findOrFail($request->id);
        $articulo->codcont = $request->codcont;
        $articulo->codaux = $request->codaux;
        $articulo->descripcion = $request->descripcion;
        $articulo->observ = $request->observacion;
        $articulo->codestado = $request->estado;
        $articulo->codigosec = $request->codsec;
        $articulo->codimage= $request->id;
        $articulo->save();

        if ($contcodcont){
        $logs = new Logs();
        $logs->codactual = $request->id;
        $logs->descripcion = 'Se Modifico el Grupo Contable';
        $logs->user = auth()->user()->name;
        $logs->save();
        };
        if ($contcodaux){
        $logs = new Logs();
        $logs->codactual = $request->id;
        $logs->descripcion = 'Se Modifico el Auxliar';
        $logs->user = auth()->user()->name;
        $logs->save();
        };
        if ($contdescripcion){
        $logs = new Logs();
        $logs->codactual = $request->id;
        $logs->descripcion = 'Se Modifico la Descripción del Activo';
        $logs->user = auth()->user()->name;
        $logs->save();
        };
        if ($contobserv){
        $logs = new Logs();
        $logs->codactual = $request->id;
        $logs->descripcion = 'Se Modifico la observación del Activo';
        $logs->user = auth()->user()->name;
        $logs->save();
        };
        if ($contcodestado){
        $logs = new Logs();
        $logs->codactual = $request->id;
        $logs->descripcion = 'Se Modifico el Estado del Activo';
        $logs->user = auth()->user()->name;
        $logs->save();
        };
        if ($contcodsec){
        $logs = new Logs();
        $logs->codactual = $request->id;
        $logs->descripcion = 'Se Modifico el código Secundario';
        $logs->user = auth()->user()->name;
        $logs->save();
        };
   
        return response()->json(['message' => 'Datos Actualizados Correctamente!!!']);

    }
    public function updateResponasable(Request $request){
        $data = $request->data;
        $codoficina = \Auth::user()->codofic;
        $codresponsable = \Auth::user()->codresp;
        try {
            for ($i=0; $i < count($data); $i++) {

                $id = $data[$i]['id'];

                $articuloant = Actual::where('id','=',$id)->first();

                $asignacion = New Asignaciones();
                $asignacion->codactual = $id;
                $asignacion->codresp = $articuloant->codresp ;
                $asignacion->codofic = $articuloant->codofic;
                $asignacion->usuario = \Auth::user()->name;
                $asignacion->save();
                        
                $articulo = Actual::findOrFail($id);
                $articulo->codresp = $codresponsable;
                $articulo->codofic = $codoficina;
                $articulo->estadoasignacion = 0;
                $articulo->save();
                
                $logs = new Logs();
                $logs->codactual = $id;
                $logs->descripcion = 'Se Modifico el Responsable y Oficina';
                $logs->user = \Auth::user()->name;
                $logs->save();
            }
            
            } catch (Exception $e) {
            return response()->json(['message' => 'Excepción capturada: '.$e->getMessage()]);
            }
            return response()->json(['message' => 'Datos Actualizados Correctamente!!!']);
    }
    public function imprimir($id){
        $actual = Actual::find($id);
        $responsable = Responsables::select('nomresp')->where('codresp','=',$actual->codresp)->first();
        $codcont = CodigoContable::select('nombre')->where('codcont','=',$actual->codcont)->first();
        $auxiliar = Auxiliares::select('nomaux')->where('codaux','=',$actual->codaux)->first();
        $oficina = Oficinas::select('nomofic')->where('codofic','=',$actual->codofic)->first();
        $qr = QrCode::generate('http://emi.test/actuales/veractual/'.$actual->id);
        $pdf = \PDF::loadView('plantillapdf.pdf',compact('actual','responsable','codcont','auxiliar','oficina','qr'));
        $pdf->set_paper("A7", "landscape");
        return $pdf->download('ejemplo.pdf');
    }
    public function verinvitado($id){
        $actual = $this->actuales->obtenerActualPorId($id);
        $responsable = Responsables::select('nomresp')->where('codresp','=',$actual->codresp)->first();
        $codcont = CodigoContable::select('nombre')->where('codcont','=',$actual->codcont)->first();
        $auxiliar = Auxiliares::select('nomaux')->where('codaux','=',$actual->codaux)->first();
        $oficina = Oficinas::select('nomofic')->where('codofic','=',$actual->codofic)->first();
        return view('actuales.actualver', ['actual' => $actual,'responsable'=>$responsable,'codcont'=>$codcont,'auxiliar'=>$auxiliar,'oficina'=>$oficina]);
    }
    public function actualizarDatos(){
        $table = new TableReader(public_path('vsiaf/dbfs/ACTUAL.DBF'),['encoding' => 'cp1252']);
        $actuales=Actual::count();
        $contador = 0;

        while ($record = $table->nextRecord()) {
        $contador ++;
        if($actuales < $contador){
            DB::table('actual')->insert([
                'unidad' => $record->get('unidad'), 
                'entidad' => $record->get('entidad'),
                'codigo' => $record->get('codigo'),
                'codcont' => $record->get('codcont'),
                'codaux' => $record->get('codaux'),
                'vidautil' => $record->get('vidautil'),
                'descripcion' => $record->get('descrip'),
                'costo' => $record->get('costo'),
                'depacu' => $record->get('depacu'),
                'mes' => $record->get('mes'), 
                'año' => $record->get('ano'), 
                'b_rev' => $record->get('b_rev'),
                'dia' => $record->get('dia'), 
                'codofic' => $record->get('codofic'),
                'codresp' => $record->get('codresp'),
                'observ' => $record->get('observ'),
                'dia_ant' => $record->get('dia_ant'), 
                'mes_ant' => $record->get('mes_ant'), 
                'año_ant' => $record->get('ano_ant'),
                'vut_ant' => $record->get('vut_ant'),
                'costo_ant' => $record->get('costo_ant'),
                'band_ufv' => $record->get('band_ufv'), 
                'codestado' => $record->get('codestado'),
                'cod_rube' => $record->get('cod_rube'),
                'nro_conv' => $record->get('nro_conv'),
                'org_fin' => $record->get('org_fin'),
                'usuar' => $record->get('usuar'),
                'api_estado' => $record->get('api_estado'),
                'codigosec' => $record->get('codigosec'),
                'banderas' => $record->get('banderas'),
                'fec_mod' => $record->get('fec_mod'),
                'usu_mod' => $record->get('usu_mod'),
            ]);
            }
        }
        $table->close();

        if($actuales == $contador){
            return response()->json(['message' => 'No hay Registros Nuevos!!!']);
            } 
        else{
            return response()->json(['message' => 'Datos Actualizados Correctamente!!!']);
            }
    }
    public function reporteActivos()
    {   
        $idrol = \Auth::user()->idrol;
        if($idrol == 1){
            $actuales = Actual::join('unidadadmin','actual.unidad','=','unidadadmin.unidad')
                                ->join('oficina', function ($join) {
                                    $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                                    $join->on('actual.codofic', '=', 'oficina.codofic');
                                })
                                ->join('resp', function ($join) {
                                            $join->on('unidadadmin.unidad', '=', 'resp.unidad');
                                            $join->on('resp.codofic', '=', 'oficina.codofic');
                                            $join->on('actual.codresp', '=', 'resp.codresp');
                                            $join->on('actual.codofic', '=', 'resp.codofic');
                                        })
                                ->join('codcont','actual.codcont','=','codcont.codcont')
                                ->join('auxiliar', function ($join) {
                                    $join->on('unidadadmin.unidad', '=', 'auxiliar.unidad');
                                    $join->on('auxiliar.codcont', '=', 'codcont.codcont');
                                    $join->on('actual.codaux', '=', 'auxiliar.codaux');
                                    $join->on('actual.codcont', '=', 'auxiliar.codcont');
                                })
                                ->join('estado','actual.codestado','=','estado.codestado')
                                ->select('actual.id','actual.unidad','actual.codigo','codcont.nombre',
                                'auxiliar.nomaux','actual.vidautil','oficina.nomofic','resp.nomresp',
                                'actual.descripcion','estado.nomestado','actual.estadoasignacion',
                                'actual.codigosec','actual.observ','actual.codcont','actual.codaux')
                                ->distinct()->get();
        }else{
            $actuales = Actual::join('codcont','actual.codcont','=','codcont.codcont')
            ->join('auxiliar',function ($join) {
            $join->on('actual.codaux', '=', 'auxiliar.codaux');
                $join->on('actual.unidad', '=', 'auxiliar.unidad');
                $join->on('actual.codcont', '=', 'auxiliar.codcont');
            })
            ->join('oficina',function ($join) {
            $join->on('actual.codofic', '=', 'oficina.codofic');
                $join->on('actual.unidad', '=', 'oficina.unidad');
            })
            ->join('resp',function ($join) {
            $join->on('actual.codresp', '=', 'resp.codresp');
                $join->on('actual.codofic', '=', 'resp.codofic');
                $join->on('actual.unidad', '=', 'resp.unidad');
            })
            ->join('estado','actual.codestado','=','estado.codestado')
            ->select('actual.id','actual.unidad','actual.codigo','codcont.nombre',
            'auxiliar.nomaux','actual.vidautil','oficina.nomofic','resp.nomresp',
            'actual.descripcion','estado.nomestado','actual.estadoasignacion',
            'actual.codigosec','actual.observ','actual.codcont','actual.codaux')
            ->where('actual.unidad','=',\Auth::user()->unidad)
            ->distinct()->get();  
        }
        return response()->json(['actuales'=>$actuales]);
    }
    public function buscarActivos(Request $request){
        $data = $request->filtro;
        $actuales = Actual::join('unidadadmin','actual.unidad','=','unidadadmin.unidad')
        ->join('oficina', function ($join) {
            $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
            $join->on('actual.codofic', '=', 'oficina.codofic');
        })
        ->join('resp', function ($join) {
                    $join->on('unidadadmin.unidad', '=', 'resp.unidad');
                    $join->on('resp.codofic', '=', 'oficina.codofic');
                    $join->on('actual.codresp', '=', 'resp.codresp');
                    $join->on('actual.codofic', '=', 'resp.codofic');
                })
        ->join('codcont','actual.codcont','=','codcont.codcont')
        ->join('auxiliar', function ($join) {
            $join->on('unidadadmin.unidad', '=', 'auxiliar.unidad');
            $join->on('auxiliar.codcont', '=', 'codcont.codcont');
            $join->on('actual.codaux', '=', 'auxiliar.codaux');
            $join->on('actual.codcont', '=', 'auxiliar.codcont');
        })
        ->select('actual.id', 'actual.unidad', 'actual.codigo', 'codcont.nombre',
                'auxiliar.nomaux', 'actual.vidautil', 'oficina.nomofic', 'resp.nomresp',
                'actual.descripcion', 'actual.codestado', 'actual.estadoasignacion',
                'actual.codresp','actual.codofic','actual.codaux')
        ->where('unidadadmin.unidad','=',$request->unidad)
        ->distinct()
        ->where('actual.codigo','=',$data)->get();
        return response()->json(['actuales'=>$actuales]);
    }
    public function buscarActivoResp(Request $request){
        $codresp = $request->codresp;
        $codofic = $request->codofic;
        $unidad = $request->unidad;
        $actuales = Actual::where('actual.codresp','=',$codresp)
                    ->where('actual.codofic','=',$codofic)
                    ->where('actual.unidad','=',$unidad)
                    ->get();
        return response()->json(['actuales'=>$actuales,'total'=>$actuales->count()]);
    }
    public function updateAsignacion(Request $request){
        $data = $request->data;
        $codresp = $request->codresp2;
        $codofic = $request->codofic2;
        $unidad = $request->unidad;
        try {
           $id_dev = New actaDevolucion();
           $id_dev->save();

           $id_asig = New actaAsignacion();
           $id_asig->save();

           for ($i=0; $i < count($data); $i++) {
                
                $id = $data[$i]['id'];

                $articuloant = Actual::where('id','=',$id)->first();

                $devolucion = New Asignaciones();
                $devolucion->codactual = $id;
                $devolucion->unidad = $articuloant->unidad;
                $devolucion->codresp = $articuloant->codresp;
                $devolucion->codofic = $articuloant->codofic;
                $devolucion->usuario = \Auth::user()->name;
                $devolucion->descripcion = 0;
                $devolucion->id_asignacion = $id_dev->id;
                $devolucion->save();

                $asignacion = New Asignaciones();
                $asignacion->codactual = $id;
                $asignacion->unidad = $unidad;
                $asignacion->codresp = $codresp;
                $asignacion->codofic = $codofic;
                $asignacion->usuario = \Auth::user()->name;
                $asignacion->descripcion = 1;
                $asignacion->id_asignacion = $id_asig->id;
                $asignacion->save();

                $articulo = Actual::findOrFail($id);
                $articulo->unidad = $unidad;
                $articulo->codresp = $codresp;
                $articulo->codofic = $codofic;
                $articulo->save();
                
                $logs = new Logs();
                $logs->codactual = $data[$i]['id'];
                $logs->descripcion = 'Se Modifico el Responsable y Oficina';
                $logs->user = \Auth::user()->name;
                $logs->save();
                
                $codigo = $data[$i]['codigo'];

            }
            
        } catch (Exception $e) {
            return response()->json(['message' => 'Excepción capturada: '.$e->getMessage()]);
        }
            return response()->json(['message' => 'Datos Actualizados Correctamente!!!','id_dev'=>$id_dev->id,'id_asig'=>$id_asig->id]);
    }
    public function repAsignaciones(Request $request){
        Date::setLocale('es');
        if(isset($request->fecha)){
            $fechaTitulo = Date::parse($request->fecha)->format('j \\de F \\de Y');
            }
        else{
            $fechaTitulo = Date::now()->format('l j F Y');
        }
        $fechDerecha = Date::now()->format('d/M/Y');
        $unidad = $request->unidad;
        if($request->data==''){
            $codcont = $request->codcont;
            $datos = Actual::join('auxiliar',function ($join) {
                    $join->on('actual.codaux', '=', 'auxiliar.codaux');
                    $join->on('actual.codcont', '=', 'auxiliar.codcont');
                })
                ->join('estado','actual.codestado','=','estado.id')
                ->join('unidadadmin','actual.unidad','=','unidadadmin.unidad')
                ->select('actual.codigo','actual.codaux','auxiliar.nomaux','actual.observ',
                'estado.nomestado', 'actual.descripcion')
                ->distinct()
                ->where('actual.unidad','=',$unidad)
                ->where('actual.codresp','=',$request->codresp)
                ->where('actual.codofic','=',$request->codofic)->get();
            $total = $datos->count();
        }else{
            $arraycodcont = explode(",", $request->data);
            $datos=[];
            $actuales = Actual::join('auxiliar',function ($join) {
                $join->on('actual.codaux', '=', 'auxiliar.codaux');
                $join->on('actual.codcont', '=', 'auxiliar.codcont');
            })
            ->join('estado','actual.codestado','=','estado.id')
            ->join('unidadadmin','actual.unidad','=','unidadadmin.unidad')
            ->select('actual.codigo','actual.codaux','auxiliar.nomaux','estado.nomestado', 'actual.descripcion','actual.codcont','actual.observ')
            ->distinct()
            ->where('actual.unidad','=',$unidad)
            ->where('actual.codresp','=',$request->codresp)
            ->where('actual.codofic','=',$request->codofic)
            ->get();

            for ($i=0; $i < count($arraycodcont); $i++) {
                for($j=0; $j < count($actuales); $j++){
                    
                    if($arraycodcont[$i] == $actuales[$j]->codcont){
                        $datos[]=$actuales[$j];
                        //array_push($datos, $actuales[$j]);
                    }
                }
            }
            $total = count($datos);
        }
        $responsable = Responsables::join('unidadadmin','resp.unidad','=','unidadadmin.unidad')
                                    ->join('oficina', function ($join) {
                                        $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                                        $join->on('resp.codofic', '=', 'oficina.codofic');
                                    })
                                    ->select('resp.nomresp','oficina.nomofic','resp.cargo','oficina.codofic','resp.ci','unidadadmin.descrip as unidad')
                                    ->where('resp.unidad','=',$unidad)
                                    ->where('resp.codresp','=',$request->codresp)
                                    ->where('resp.codofic','=',$request->codofic)->first();
        
        $pdf=Pdf::loadView('plantillapdf.repAsignacion',['datos'=>$datos,'responsable'=>$responsable,'fechaTitulo'=>$fechaTitulo,'fechaDerecha'=>$fechDerecha,'total'=>$total, 'unidad'=>$unidad]);
        $pdf->set_paper(array(0,0,800,617));
        return $pdf->stream();
    }
    public function repDevoluciones(Request $request){
        
        Date::setLocale('es');
        if(isset($request->fecha)){
            $fechaTitulo = Date::parse($request->fecha)->format('j \\de F \\de Y');
            }
        else{
            $fechaTitulo = Date::now()->format('l j F Y');
        }
        $fechDerecha = Date::now()->format('d/M/Y');
        $unidad = $request->unidad;
        if($request->data==''){
            $codcont = $request->codcont;
            $datos = Actual::join('auxiliar',function ($join) {
                    $join->on('actual.codaux', '=', 'auxiliar.codaux');
                        $join->on('actual.codcont', '=', 'auxiliar.codcont');
                })
                ->join('estado','actual.codestado','=','estado.id')
                ->select('actual.codigo','actual.codaux','auxiliar.nomaux','estado.nomestado', 'actual.descripcion',)
                ->distinct()
                ->where('actual.unidad','=',$unidad)
                ->where('actual.codresp','=',$request->codresp)
                ->where('actual.codofic','=',$request->codofic)->get();
            $total = $datos->count();
        }else{
            $arraycodcont = explode(",", $request->data);
            $datos=[];
            $actuales = Actual::join('auxiliar',function ($join) {
                $join->on('actual.codaux', '=', 'auxiliar.codaux');
                    $join->on('actual.codcont', '=', 'auxiliar.codcont');
            })
            ->join('estado','actual.codestado','=','estado.id')
            ->select('actual.codigo','actual.codaux','auxiliar.nomaux','estado.nomestado', 'actual.descripcion','actual.codcont')
            ->distinct()
            ->where('actual.unidad','=',$unidad)
            ->where('actual.codresp','=',$request->codresp)
            ->where('actual.codofic','=',$request->codofic)
            ->get();

            for ($i=0; $i < count($arraycodcont); $i++) {
                for($j=0; $j < count($actuales); $j++){
                    
                    if($arraycodcont[$i] == $actuales[$j]->codcont){
                        $datos[]=$actuales[$j];
                        //array_push($datos, $actuales[$j]);
                    }
                }
            }
            $total = count($datos);
        }
        $responsable =  Responsables::join('unidadadmin','resp.unidad','=','unidadadmin.unidad')
                                    ->join('oficina', function ($join) {
                                        $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                                        $join->on('resp.codofic', '=', 'oficina.codofic');
                                    })
                                    ->select('resp.nomresp','oficina.nomofic','resp.cargo','oficina.codofic','resp.ci','unidadadmin.descrip as unidad')
                                    ->where('resp.codresp','=',$request->codresp)
                                    ->where('resp.codofic','=',$request->codofic)->first();
        $pdf=Pdf::loadView('plantillapdf.repDevolucion',['datos'=>$datos,'responsable'=>$responsable,'fechaTitulo'=>$fechaTitulo,'fechaDerecha'=>$fechDerecha,'total'=>$total, 'unidad'=>$unidad]);
        $pdf->set_paper(array(0,0,800,617));
        return $pdf->stream();
        
    }
    public function buscarActivoEstado(Request $request){  
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $unidad = $request->unidad;

        if ($buscar==''){
              $actuales = Actual::join('unidadadmin','actual.unidad','=','unidadadmin.unidad')
                    ->join('oficina', function ($join) {
                        $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                        $join->on('actual.codofic', '=', 'oficina.codofic');
                    })
                    ->join('resp', function ($join) {
                                $join->on('unidadadmin.unidad', '=', 'resp.unidad');
                                $join->on('resp.codofic', '=', 'oficina.codofic');
                                $join->on('actual.codresp', '=', 'resp.codresp');
                                $join->on('actual.codofic', '=', 'resp.codofic');
                            })
                    ->join('codcont','actual.codcont','=','codcont.codcont')
                    ->join('auxiliar', function ($join) {
                        $join->on('unidadadmin.unidad', '=', 'auxiliar.unidad');
                        $join->on('auxiliar.codcont', '=', 'codcont.codcont');
                        $join->on('actual.codaux', '=', 'auxiliar.codaux');
                        $join->on('actual.codcont', '=', 'auxiliar.codcont');
                    })
                    ->select('actual.id', 'actual.unidad', 'actual.codigo', 'codcont.nombre',
                            'auxiliar.nomaux', 'actual.vidautil', 'oficina.nomofic', 'resp.nomresp',
                            'actual.descripcion', 'actual.codestado', 'actual.estadoasignacion',
                            'actual.codresp','actual.codofic','actual.codaux')
                    ->where('unidadadmin.unidad','=',$unidad)
                    ->distinct()
                    ->paginate(5);
        }
        else{
            $actuales = Actual::join('unidadadmin','actual.unidad','=','unidadadmin.unidad')
                    ->join('oficina', function ($join) {
                        $join->on('unidadadmin.unidad', '=', 'oficina.unidad');
                        $join->on('actual.codofic', '=', 'oficina.codofic');
                    })
                    ->join('resp', function ($join) {
                                $join->on('unidadadmin.unidad', '=', 'resp.unidad');
                                $join->on('resp.codofic', '=', 'oficina.codofic');
                                $join->on('actual.codresp', '=', 'resp.codresp');
                                $join->on('actual.codofic', '=', 'resp.codofic');
                            })
                    ->join('codcont','actual.codcont','=','codcont.codcont')
                    ->join('auxiliar', function ($join) {
                        $join->on('unidadadmin.unidad', '=', 'auxiliar.unidad');
                        $join->on('auxiliar.codcont', '=', 'codcont.codcont');
                        $join->on('actual.codaux', '=', 'auxiliar.codaux');
                        $join->on('actual.codcont', '=', 'auxiliar.codcont');
                    })
                    ->select('actual.id', 'actual.unidad', 'actual.codigo', 'codcont.nombre',
                        'auxiliar.nomaux', 'actual.vidautil', 'oficina.nomofic', 'resp.nomresp',
                        'actual.descripcion', 'actual.codestado', 'actual.estadoasignacion',
                        'actual.codresp','actual.codofic','actual.codaux')
                    ->where('unidadadmin.unidad','=',$unidad)
                    ->distinct()
                    ->where('actual.'.$criterio, 'like', '%'. $buscar . '%')->paginate(5);
        }
        return [
                'pagination' => [
                    'total'        => $actuales->total(),
                    'current_page' => $actuales->currentPage(),
                    'per_page'     => $actuales->perPage(),
                    'last_page'    => $actuales->lastPage(),
                    'from'         => $actuales->firstItem(),
                    'to'           => $actuales->lastItem(),
                ],
                'actuales'=>$actuales,
                ];
    }
    public function gcontable(Request $request){
        $codresp = $request->codresp;
        $codofic = $request->codofic;
        $unidad = $request->unidad;
        $gcontables = Actual::join('codcont','codcont.codcont','=','actual.codcont')
                        ->select('codcont.codcont','codcont.nombre')
                        ->distinct()
                        ->where('actual.codresp','=',$codresp)
                        ->where('actual.codofic','=',$codofic)
                        ->where('actual.unidad','=',$unidad)
                        ->get();
        return response()->json(['gcontables'=>$gcontables]);
    }
    public function auxiliar(Request $request){
        $codcont = $request->codcont;
        $codaux = $request->codaux;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $unidad = $request->unidad;
        if($buscar==''){
            $actuales = Actual::select('id','codigo','descripcion as descrip')
            ->where('codcont','=',$codcont)->where('codaux','=',$codaux)->where('unidad','=',$unidad)->get();
            return response()->json(['actuales'=>$actuales,'totalactuales'=>$actuales->count()]);
        }else{
            if($criterio=='codigo'){
            $actuales = Actual::select('id','codigo','descripcion as descrip')
            ->where('codcont','=',$codcont)
            ->where('codaux','=',$codaux)
            ->where('unidad','=',$unidad)
            ->where('actual.'.$criterio, 'like', '%'. $buscar . '%')
            ->get();
            return response()->json(['actuales'=>$actuales,'totalactuales'=>$actuales->count()]);
            }
            else{
                $actuales = Actual::select('id','codigo','descripcion as descrip')
                ->where('codcont','=',$codcont)
                ->where('codaux','=',$codaux)
                ->where('unidad','=',$unidad)
                ->where('actual.'.$criterio.'cion', 'like', '%'. $buscar . '%')
                ->get();
                return response()->json(['actuales'=>$actuales,'totalactuales'=>$actuales->count()]);
            }
        }
    }
    public function responsable(Request $request){
        $codofic = $request->codofic;
        $codresp = $request->codresp;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $unidad = $request->unidad;
        if($buscar==''){
            $actuales = Actual::select('id','codigo','descripcion')
            ->where('codofic','=',$codofic)
            ->where('codresp','=',$codresp)
            ->where('unidad','=',$unidad)
            ->get();
            return response()->json(['actuales'=>$actuales,'totalactuales'=>$actuales->count()]);
        }else{
            $actuales = Actual::select('id','codigo','descripcion')
            ->where('codofic','=',$codofic)
            ->where('codresp','=',$codresp)
            ->where('unidad','=',$unidad)
            ->where('actual.'.$criterio, 'like', '%'. $buscar . '%')
            ->get();
            return response()->json(['actuales'=>$actuales,'totalactuales'=>$actuales->count()]);
        }
    }
}
