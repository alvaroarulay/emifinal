<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use App\Models\Actual;
use App\Models\Responsables;
use XBase\Enum\FieldType;
use XBase\Enum\TableType;
use XBase\Header\Column;
use XBase\Header\HeaderFactory;
use XBase\TableCreator;
use XBase\TableEditor;
use XBase\TableReader;

class ZipArchiveController extends Controller
{
    public function downloadZip()
    {         
        try {
                $this->deleteDBF();
                $this->deleteRespDBF();
                //$this->createDBF();
                $this->llenarDBF();
                $this->llenarRespDBF();
                $zip = new ZipArchive;
                $date = Carbon::now();
                $fileName = 'VS'.$date->format('Ymd') . '.' .'zip';
                if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                {
                    $files = \File::files(public_path('vsiaf/dbfs'));

                    foreach ($files as $key => $value) {
                        $file = basename($value);
                        $zip->addFile($value, $file);
                    }

                    $zip->close();
                }
                return response()->download(public_path($fileName));
            
            } catch (Exception $e) {

               return print_r("hubo un error");
                // return response()->json(['message' => 'Excepción capturada: '.$e->getMessage()]);
            }
            
    }
    public function deleteDBF()
    {
        try {
             // Ruta del archivo
            $filePath = public_path('vsiaf/dbfs/ACTUAL.DBF');
            // Verifica si el archivo existe
            if (file_exists($filePath) ) {
            // Elimina el archivo
            //Storage::delete($filePath);
            unlink($filePath);
           
            $this->createDBF();
            } else {
                $this->createDBF();
            }
        
        } catch (Exception $e) {

           return print_r("hubo un error");
            // return response()->json(['message' => 'Excepción capturada: '.$e->getMessage()]);
        }
    }
    public function deleteRespDBF()
    {
        try {
             // Ruta del archivo
            $filePath = public_path('vsiaf/dbfs/resp.DBF');
            // Verifica si el archivo existe
            if (file_exists($filePath) ) {
            // Elimina el archivo
            //Storage::delete($filePath);
            unlink($filePath);
           
            $this->createRespDBF();
            } else {
                $this->createRespDBF();
            }
        
        } catch (Exception $e) {

           return print_r("hubo un error");
            // return response()->json(['message' => 'Excepción capturada: '.$e->getMessage()]);
        }
    }
    protected function createDBF(){
        $header = HeaderFactory::create(TableType::DBASE_III_PLUS_MEMO);
        $filepath = public_path('vsiaf/dbfs/ACTUAL.DBF');

        $tableCreator = new TableCreator($filepath, $header);
        $tableCreator
            ->addColumn(new Column([
                'name'   => 'unidad',
                'type'   => FieldType::CHAR,
                'length' => 5,
            ]))
            ->addColumn(new Column([
                'name'   => 'entidad',
                'type'   => FieldType::CHAR,
                'length' => 4,
            ]))
            ->addColumn(new Column([
                'name'   => 'codigo',
                'type'   => FieldType::CHAR,
                'length' => 15,
            ]))
            ->addColumn(new Column([
                'name'         => 'codcont',
                'type'         => FieldType::NUMERIC,
                'length'       => 2,
                'decimalCount' => 0,
            ]))
            ->addColumn(new Column([
                'name'         => 'codaux',
                'type'         => FieldType::NUMERIC,
                'length'       => 3,
                'decimalCount' => 0,
            ]))
            ->addColumn(new Column([
                'name'         => 'vidautil',
                'type'         => FieldType::NUMERIC,
                'length'       => 6,
                'decimalCount' => 2,
            ]))
            ->addColumn(new Column([
                'name'   => 'descrip',
                'type'   => FieldType::CHAR,
                'length' => 150,
            ]))
            ->addColumn(new Column([
                'name'         => 'costo',
                'type'         => FieldType::NUMERIC,
                'length'       => 15,
                'decimalCount' => 2,
            ]))
            ->addColumn(new Column([
                'name'         => 'depacu',
                'type'         => FieldType::NUMERIC,
                'length'       => 15,
                'decimalCount' => 2,
            ]))
            ->addColumn(new Column([
                'name'         => 'mes',
                'type'         => FieldType::NUMERIC,
                'length'       => 2,
                'decimalCount' => 0,
            ]))
            ->addColumn(new Column([
                'name'         => 'ano',
                'type'         => FieldType::NUMERIC,
                'length'       => 4,
                'decimalCount' => 0,
            ]))
            ->addColumn(new Column([
                'name'   => 'b_rev',
                'type'   => FieldType::LOGICAL,
            ]))
            ->addColumn(new Column([
                'name'         => 'dia',
                'type'         => FieldType::NUMERIC,
                'length'       => 2,
                'decimalCount' => 0,
            ]))
            ->addColumn(new Column([
                'name'         => 'codofic',
                'type'         => FieldType::NUMERIC,
                'length'       => 4,
                'decimalCount' => 0,
            ]))
            ->addColumn(new Column([
                'name'         => 'codresp',
                'type'         => FieldType::NUMERIC,
                'length'       => 5,
                'decimalCount' => 0,
            ]))
            ->addColumn(new Column([
                'name'   => 'observ',
                'type'   => FieldType::MEMO,
                'length'       => 10,
            ]))
            ->addColumn(new Column([
                'name'         => 'dia_ant',
                'type'         => FieldType::NUMERIC,
                'length'       => 2,
                'decimalCount' => 0,
            ]))
            ->addColumn(new Column([
                'name'         => 'mes_ant',
                'type'         => FieldType::NUMERIC,
                'length'       => 2,
                'decimalCount' => 0,
            ])) 
            ->addColumn(new Column([
                'name'         => 'ano_ant',
                'type'         => FieldType::NUMERIC,
                'length'       => 4,
                'decimalCount' => 0,
            ]))  
            ->addColumn(new Column([
                'name'         => 'vut_ant',
                'type'         => FieldType::NUMERIC,
                'length'       => 3,
                'decimalCount' => 0,
            ]))
            ->addColumn(new Column([
                'name'         => 'costo_ant',
                'type'         => FieldType::NUMERIC,
                'length'       => 15,
                'decimalCount' => 2,
            ]))
            ->addColumn(new Column([
                'name'   => 'band_ufv',
                'type'   => FieldType::LOGICAL,
            ]))
            ->addColumn(new Column([
                'name'         => 'codestado',
                'type'         => FieldType::NUMERIC,
                'length'       => 2,
                'decimalCount' => 0,
            ]))
            ->addColumn(new Column([
                'name'   => 'cod_rube',
                'type'   => FieldType::CHAR,
                'length' => 15,
            ]))
            ->addColumn(new Column([
                'name'   => 'nro_conv',
                'type'   => FieldType::CHAR,
                'length' => 10,
            ]))
            ->addColumn(new Column([
                'name'   => 'org_fin',
                'type'   => FieldType::CHAR,
                'length' => 3,
            ]))
            ->addColumn(new Column([
                'name'   => 'feult',
                'type'   => FieldType::DATE,
                'length' => 8,
            ]))
            ->addColumn(new Column([
                'name'   => 'usuar',
                'type'   => FieldType::CHAR,
                'length' => 8,
            ]))
            ->addColumn(new Column([
                'name'         => 'api_estado',
                'type'         => FieldType::NUMERIC,
                'length'       => 1,
                'decimalCount' => 0,
            ]))
            ->addColumn(new Column([
                'name'   => 'codigosec',
                'type'   => FieldType::CHAR,
                'length' => 15,
            ]))
            ->addColumn(new Column([
                'name'   => 'banderas',
                'type'   => FieldType::CHAR,
                'length' => 12,
            ]))
            ->addColumn(new Column([
                'name'   => 'fec_mod',
                'type'   => FieldType::DATE,
                'length' => 8,
            ]))
            ->addColumn(new Column([
                'name'   => 'usu_mod',
                'type'   => FieldType::CHAR,
                'length' => 8,
            ]))
            ->save(); //creates file

    }
    protected function llenarDBF(){
       $actuales = Actual::all();
        try {
            $table = new TableEditor(public_path('vsiaf/dbfs/ACTUAL.DBF'),['encoding' => 'cp1252']);
            for ($i=0; $i < count($actuales); $i++) {

                $record = $table->appendRecord();

                $record->set('unidad',  $actuales[$i]['unidad'] );
                $record->set('entidad', $actuales[$i]['entidad'] );
                $record->set('codigo', $actuales[$i]['codigo'] );
                $record->set('codcont', $actuales[$i]['codcont'] );
                $record->set('codaux', $actuales[$i]['codaux'] );
                $record->set('vidautil', $actuales[$i]['vidautil'] );
                $record->set('descrip', $actuales[$i]['descripcion'] );
                $record->set('costo', $actuales[$i]['costo'] );
                $record->set('depacu', $actuales[$i]['depacu'] );
                $record->set('mes', $actuales[$i]['mes'] );
                $record->set('ano', $actuales[$i]['año'] );
                $record->set('b_rev', (boolean)$actuales[$i]['b_rev'] );
                $record->set('dia', $actuales[$i]['dia'] );
                $record->set('codofic', $actuales[$i]['codofic'] );
                $record->set('codresp', $actuales[$i]['codresp'] );
                $record->set('observ', $actuales[$i]['observ'] );
                $record->set('dia_ant', $actuales[$i]['dia_ant'] );
                $record->set('mes_ant', $actuales[$i]['mes_ant'] );
                $record->set('ano_ant', $actuales[$i]['año_ant'] );
                $record->set('vut_ant', $actuales[$i]['vut_ant'] );
                $record->set('costo_ant', $actuales[$i]['costo_ant'] );
                $record->set('band_ufv', (boolean)$actuales[$i]['band_ufv'] );
                $record->set('codestado', $actuales[$i]['codestado'] );
                $record->set('cod_rube', $actuales[$i]['cod_rube'] );
                $record->set('nro_conv', $actuales[$i]['nro_conv'] );
                $record->set('org_fin', $actuales[$i]['org_fin'] );
                $record->set('usuar', $actuales[$i]['usuar'] );
                $record->set('api_estado', $actuales[$i]['api_estado'] );
                $record->set('codigosec', $actuales[$i]['codigosec'] );
                $record->set('banderas', $actuales[$i]['banderas'] );
                $record->set('fec_mod', $actuales[$i]['fec_mod'] );
                $record->set('usu_mod', $actuales[$i]['usu_mod'] );

                $table->writeRecord()->save();
            }
            $table->close();
            return response()->json(['message' => 'Datos Actualizados Correctamente!!!']);
            } catch (Exception $e) {
                return print_r("hubo un error");
            //return response()->json(['message' => 'Excepción capturada: '.$e->setMessage()]);
            }
            
    }
    protected function createRespDBF(){
        $header = HeaderFactory::create(TableType::DBASE_III_PLUS_MEMO);
        $filepath = public_path('vsiaf/dbfs/resp.DBF');

        $tableCreator = new TableCreator($filepath, $header);
        $tableCreator
            ->addColumn(new Column([
                'name'   => 'entidad',
                'type'   => FieldType::CHAR,
                'length' => 4,
            ]))
            ->addColumn(new Column([
                'name'   => 'unidad',
                'type'   => FieldType::CHAR,
                'length' => 5,
            ]))
            ->addColumn(new Column([
                'name'   => 'codofic',
                'type'   => FieldType::NUMERIC,
                'length' => 4,
            ]))
            ->addColumn(new Column([
                'name'         => 'codresp',
                'type'         => FieldType::NUMERIC,
                'length'       => 5,
                'decimalCount' => 0,
            ]))
            ->addColumn(new Column([
                'name'   => 'nomresp',
                'type'   => FieldType::CHAR,
                'length' => 35,
            ]))
            ->addColumn(new Column([
                'name'   => 'cargo',
                'type'   => FieldType::CHAR,
                'length' => 35,
            ]))
            ->addColumn(new Column([
                'name'   => 'observ',
                'type'   => FieldType::MEMO,
                'length'       => 10,
            ]))
            ->addColumn(new Column([
                'name'         => 'ci',
                'type'         => FieldType::CHAR,
                'length'       => 20,
            ]))
            ->addColumn(new Column([
                'name'   => 'feult',
                'type'   => FieldType::DATE,
                'length' => 8,
            ]))
            ->addColumn(new Column([
                'name'   => 'usuar',
                'type'   => FieldType::CHAR,
                'length' => 8,
            ]))
            ->addColumn(new Column([
                'name'         => 'cod_exp',
                'type'         => FieldType::NUMERIC,
                'length'       => 2,
                'decimalCount' => 0,
            ]))
            ->addColumn(new Column([
                'name'   => 'api_estado',
                'type'   => FieldType::NUMERIC,
                'length' => 1,
            ]))
            ->save(); //creates file

    }
    protected function llenarRespDBF(){
       $responsables = Responsables::all();
        try {
            $table = new TableEditor(public_path('vsiaf/dbfs/resp.DBF'),['encoding' => 'cp1252']);
            for ($i=0; $i < count($responsables); $i++) {

                $record = $table->appendRecord();
                $record->set('entidad', $responsables[$i]['entidad'] );
                $record->set('unidad',  $responsables[$i]['unidad'] );
                $record->set('codofic', $responsables[$i]['codofic'] );
                $record->set('codresp', $responsables[$i]['codresp'] );
                $record->set('nomresp', $responsables[$i]['nomresp'] );
                $record->set('cargo', $responsables[$i]['cargo'] );
                $record->set('observ', $responsables[$i]['observ'] );
                $record->set('ci', $responsables[$i]['ci'] );
                $record->set('feult', $responsables[$i]['feult'] );
                $record->set('usuar', $responsables[$i]['usuar'] );
                $record->set('cod_exp', $responsables[$i]['cod_exp'] );
                $record->set('api_estado', $responsables[$i]['api_estado'] );
                $table->writeRecord()->save();
            }
            $table->close();
            return response()->json(['message' => 'Datos Actualizados Correctamente!!!']);
            } catch (Exception $e) {
                return print_r("hubo un error");
            //return response()->json(['message' => 'Excepción capturada: '.$e->setMessage()]);
            }
            
    }
}
