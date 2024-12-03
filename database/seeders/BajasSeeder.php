<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class BajasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new TableReader(public_path('vsiaf/dbfs/BAJAS.DBF'),['encoding' => 'cp1252']);
        while ($record = $table->nextRecord()) {
            DB::table('bajas')->insert([
                'entidad' => $record->get('entidad'),
                'unidad' => $record->get('unidad'),
                'codigo' => $record->get('codigo'),
                'codbaja' => $record->get('codbaja'),
                'codcont' => $record->get('codcont'),
                'codaux' => $record->get('codaux'),
                'codofic' => $record->get('codofic'),
                'codresp' => $record->get('codresp'),
                'costo' => $record->get('costo'), 
                'depacu_ant' => $record->get('depacu_ant'),
                'descrip' => $record->get('descrip'),
                'd_baja' => $record->get('d_baja'),
                'dia' => $record->get('dia'), 
                'm_baja' => $record->get('m_baja'),
                'mes' => $record->get('mes'), 
                'a_baja' => $record->get('a_baja'),
                'año' => $record->get('ano'), 
                'b_rev' => $record->get('b_rev'),
                'vidautil' => $record->get('vidautil'),
                'resolucion' => $record->get('resolucion'),
                'motivo' => $record->get('motivo'),
                'depacu' => $record->get('depacu'),
                'actua' => $record->get('actua'), 
                'depgestion' => $record->get('depgestion'),
                'cosbajini' => $record->get('cosbajini'),
                'cosdaini' => $record->get('cosdaini'),
                'cosactbaj' => $record->get('cosactbaj'),
                'actdabaj' => $record->get('actdabaj'),
                'usuar' => $record->get('usuar'),
                'feult' => $record->get('feult'),
                'fec_mod' => $record->get('fec_mod'),
                'usu_mod' => $record->get('usu_mod'),
                'created_at'=>now(),
                'updated_at'=>now(),
          ]);
        }
    }
}
