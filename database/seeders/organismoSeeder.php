<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class organismoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new TableReader(public_path('vsiaf/dbfs/organismo_fin.dbf'),['encoding' => 'cp1252']);
        while ($record = $table->nextRecord()) {
            DB::table('organismo_fin')->insert([
                'gestion' => $record->get('gestion'),
                'of' => $record->get('of'), 
                'des' => $record->get('des'), 
                'sigla' => $record->get('sigla'),
                'created_at'=>now(),
                'updated_at'=>now(),
          ]);
        }
    }
}
