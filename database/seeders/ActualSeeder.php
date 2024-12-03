<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class ActualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new TableReader(public_path('vsiaf/dbfs/ACTUAL.DBF'),['encoding' => 'cp1252']);
        while ($record = $table->nextRecord()) {
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
            'created_at'=>now(),
            'updated_at'=>now(),
          ]);
        }
    }
}
