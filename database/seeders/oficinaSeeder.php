<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class oficinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new TableReader(public_path('vsiaf/dbfs/OFICINA.dbf'),['encoding' => 'cp1252']);
        while ($record = $table->nextRecord()) {
            DB::table('oficina')->insert([
            'entidad' => $record->get('entidad'),
            'unidad' => $record->get('unidad'),
            'codofic' => $record->get('codofic'),
            'nomofic' => $record->get('nomofic'),
            //'feult' => $record->get('feult'),
            'usuar' => $record->get('usuar'),
            'api_estado' => $record->get('api_estado'),
            'created_at'=> now(),
            'updated_at'=> now(),
          ]);
        }
    }
}
