<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class EstentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new TableReader(public_path('vsiaf/dbfs/est_ent.dbf'),['encoding' => 'cp1252']);
        while ($record = $table->nextRecord()) {
            DB::table('est_ent')->insert([ 
                'gestion' => $record->get('gestion'),
                'sector_ent' => $record->get('sector_ent'),
                'subsec_ent' => $record->get('subsec_ent'),
                'area_ent' => $record->get('area_ent'),
                'subareaent' => $record->get('subareaent'),
                'nivel_inst' => $record->get('nivel_inst'),
                'des_estruc' => $record->get('des_estruc'),
                'siglaestru' => $record->get('siglaestru'),
                'apropiable' => $record->get('apropiable'),
                'created_at'=>now(),
                'updated_at'=>now(),
          ]);
        }
    }
}
