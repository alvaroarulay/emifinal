<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class codcontSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    

   
    public function run()
    {
        $table = new TableReader(public_path('vsiaf/dbfs/CODCONT.DBF'),['encoding' => 'cp1252']);
        while ($record = $table->nextRecord()) {
            DB::table('codcont')->insert([
            'codcont' => $record->get('codcont'),
            'nombre' => $record->get('nombre'),
            'vidautil' => $record->get('vidautil'),
            'depreciar' => $record->get('depreciar'), 
            'actualizar' => $record->get('actualizar'), 
            'feult' => $record->get('feult'),
            'usuar' => $record->get('usuar'),
            'created_at'=>now(),
            'updated_at'=>now(),
          ]);
        }
    }
}


