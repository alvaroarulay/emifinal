<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class UnidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new TableReader(public_path('vsiaf/dbfs/unidadadmin.DBF'),['encoding' => 'cp1252']);
        while ($record = $table->nextRecord()) {
            DB::table('unidadadmin')->insert([
            'entidad' =>$record->get('entidad'),
            'unidad' =>$record->get('unidad'),
            'descrip' => $record->get('descrip'),
            'ciudad' => $record->get('ciudad'),
            'estadouni' => $record->get('estadouni'),
            'estado' => true,
            'created_at'=>now(),
            'updated_at'=>now(),
          ]);
        }
    }
}
