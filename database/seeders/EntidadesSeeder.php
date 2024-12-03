<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class EntidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new TableReader(public_path('vsiaf/dbfs/entidades.dbf'),['encoding' => 'cp1252']);
        while ($record = $table->nextRecord()) {
            DB::table('entidades')->insert([
                'gestion' => $record->get('gestion'), 
                'entidad' => $record->get('entidad'),
                'desc_ent' => $record->get('desc_ent'),
                'sigla_ent' => $record->get('sigla_ent'),
                'sector_ent' => $record->get('sector_ent'),
                'subsec_ent' => $record->get('subsec_ent'),
                'area_ent' => $record->get('area_ent'),
                'subareaent' => $record->get('subareaent'),
                'nivel_inst' => $record->get('nivel_inst'),
                'created_at'=>now(),
                'updated_at'=>now(),
          ]);
        }
    }
}
