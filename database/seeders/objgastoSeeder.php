<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class objgastoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new TableReader(public_path('vsiaf/dbfs/objgasto.dbf'),['encoding' => 'cp1252']);
        while ($record = $table->nextRecord()) {
            DB::table('objgasto')->insert([
                'gestion' => $record->get('gestion'),
                'partida' => $record->get('partida'), 
                'descrip' => $record->get('descrip'),
                'created_at'=>now(),
                'updated_at'=>now(),
          ]);
        }
    }
}
